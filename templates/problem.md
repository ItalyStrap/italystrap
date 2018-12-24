# Autoloading delle views per il frontend

## Come funziona ItalyStrap

Il framework è composto da un plugin per il core e dal tema per tutte le funzionalità specifiche per la grafica
Possono funzionare solo accoppiati.
L'utente può personalizzarlo con un tema child.

Sto lavorando in modo da semplificare il processo di configurazione dell'intero framework, l'utente avrà la possibilità di poter usare dei file di configurazione per ogni entità (Schema.org, Layout, Template, ecc), per questo esisterà una classe Config() che verrà passata nelle varie classi che la richiederanno.

Per fare quasto sicuramente lato codice sarà molto più complesso ma grazie ai file di configurazione anche l'utente meno esperto potrà personalizzare il tema.



## Primo problema da risolvere
### Ridurre la duplicazione che creano i template standard

Generalmente i template standard WordPress ripetono lo stesso pattern per n file, esempio di ripetizione è il div contenitore della struttura principale, questo viene ripetuto per tutti i file template, stessa cosa vale per il loop, per i titolo, immagine in evidenza e così via.

### Soluzione utilizzata

Per risolvere al problema della duplicazione sono stati creati dei frammenti di template per ogni elemento presente nella pagina renderizzata, per esempio ora esiste un unico file per il titolo che viene riutilizzato per tutte i file template presenti nel tema, stessa cosa vale per tutti gli altri elementi: immagine in evidenza, contenuto e così via come si può vedere nella struttura qui sotto dove per semplicità sono presenti solo i file per il loop e sono stati omessi tutti gli altri.

#### Struttura delle view

```php
[
	'index.php' => [
		'posts/loop.php',
		'posts/none.php'	=> [
			'posts/none/image.php',
			'posts/none/title.php',
			'posts/none/content.php',
		],
		'posts/post.php'	=> [
			'posts/parts/featured-image.php', // action: 'italystrap_entry_content' - priority: 10
			'posts/parts/title.php', // action: 'italystrap_entry_content' - priority: 20
			'posts/parts/meta.php', // action: 'italystrap_entry_content' - priority: 30
			'posts/parts/preview.php', // action: 'italystrap_entry_content' - priority: 40
			'posts/parts/content.php', // action: 'italystrap_entry_content' - priority: 50
			'posts/parts/modified.php', // action: 'italystrap_entry_content' - priority: 60
		],
		... // Struttura simile per header, footer, sidebar, comments e altro
	]
]
```

### Il problema creato con questo sistema

Se da un lato risolve il problema della duplicazione (se cambiano le specifiche del sito non devo più aprire n file template per cambiare la struttura, pensando anche in un caso estremo dove il sito ha +20 CPT, ma ne basterà modificare solo 1) di contro ha che:

* Serve un sistema per caricare questi template nella giusta posizione
* Non tutti i file template necessitano di caricare tutti i frammenti

#### Loader per le view

Il sistema più semplice è quello di utilizzare la funzione get_template_part() ma il problema usando questa funzione è che non mi consente una buona separazione tra logica e grafica, avrò sempre incluso nei template anche il codice per fare cose che in casi estremi potrebbe risultare in troppe righe di codice nello stesso file.
Inoltre per modificare qualcosa dovrò fare maggiore hardcoding.

Una soluzione trovata e sperimentata è quella di utilizzare gli eventi di WordPress (Plugin API) inserendo hook strategici nelle vaire view, sistema simile ai template di WooCommerce e Genesis, in questo modo riesco ad ottenere una maggiore separazione fra codice e grafica.

Il problema ora è trovare una soluzione per stampare una vista in uno specifico hook con una specifica priorità.

Genesis e WooCommerce hanno risolto semplicemente con il procedurale, con semplici funzioni come callback.

Questo è sicuramente molto + semplice da gestire specialmente in caso di rimozione della callback ma alcuni problemi che ho visto è che per comodità in alcuni casi potrebbero essere usate pratiche sbagliate come l'utilizzo di variabili globali.

Io pensavo invece di utilizzare un sistema pù centralizzato che consenta successivamente all'utente di poter intervenire in modo pratico.

Per questo pensavo di utilizzare delle classi specifiche con il solo compito di definire il nome della view, eseguire eventuale logica e quindi eseguire la classe specifica per stampare le view.
La view ovviamente verrà stampata allo scatenarsi dell'evento.

Per questo sistema ho giò scritto del codice, una classe genitore con i metodi che devono sempre essere disponibili e tante classi figlie, una per view, che si occuperanno di aggiungere eventuali metodi in base al bisogno.

Al momento vista la natura somigliante al pattern MVC ho chiamato queste classi controller, è comunque un nome da valutare.

Usando delle classi mi permette di sfruttare la DI nel costruttore e iniettare poi l'eventuale istanza dentro la view senza dover usare `new` dentro la view stessa.

Questo mi permette anche di istanziare oggetti particolari come un oggetto Config e condividerlo dove mi server nei Controller.

Inizialmente avevo messo il costruttore anche nella classe genitore ma mi sono reso conto che in caso dovessi cambiare le specifiche dei parametri accettati diventerebbe un problema aggiornare tutte le classi figlie (che potrebbero assere diverse decine) quindi è da valutare un pattern alternativo.

Tutte le classi sono istanziate da un autoloader che mi sono scritto e che sfrutta Auryn PHP che fa da Dipendency Injector durante after_setup_theme, a seconda di come si risolve l problema è da valutare anche un altro hook.

## Quale problema voglio risolvere

* Diminuire la duplicazione del codice che i template WordPress causano dividendo questi in piccoli frammenti o view.
* Poter caricare dinamicamente e automaticamente le view dove necessario all'interno della pagina
* Dare la possibilità all'utente di poter modificare la posizione e la priorità in cui stampare la view

Inizialmente ho preso spunto dai template di WooCommerce i quali utilizzano le action per poter stampare ogni elemento

## Come lo risolve genesis

Genesis non utilizza delle view con HTML ma fa tutto in PHP, quando deve stampare HTML utilizza una echo.

Ogni singolo elemento viene stampato nelle pagina grazie agli hook sparsi per il tema, ogni funzione viene eseguita per quel particolare hook, non utilizza il metodo classi di chiamare la funzione direttamente nel file template.

Comodo quando si vuole rimuovere qualche elemento basta un remove_{action|filter}( 'hook_name', 'callback' )

## Come lo vorrei risolvere io

La mia idea è quella di separare il più possibile HTML (che sarà comunque caricato da file php) dalla logica.

Di base è possibile farlo con get_template_part() richiamando la funzione in ogni posizione in cui deve essere visualizzata la view, es:

function print_title() {

	// Esegue eventuale codice
	// poi:

	get_template_part( 'title.php' );
}

add_filter( 'some_hook', 'print_title' );

Ma avendo atomizzato il template diventa complessa la manutenzione, per questo sto sperimentando un sistema a oggetti in cui ogni view ha il suo "controller" che si occupa di eseguire eventuale codice e poi caricare la view, prossimamente il controller avrà come dipendenza una classe View per gestire e memorizzare eventuali viste per un successivo riutilizzo (non tutte perchè alcune non necessitano di questa possibilità, vedi il file loop.php).

Il controller si occupa anche di dichiarare l'hook in cui dovrà essere eseguita la callback utilizzando l'event manager interno.

Quello che appunto voglio risolvere è associare alla rispettiva action la view che dovrà essere stampata eseguendo un loop per automatizzare.

Potrei farlo anche semplicemente in modo procedurale dove ho una mappa con l'hook come key e la callback come value ma volevo un controllo maggiore usando oggetti.


## Che cosa non va

Attualmente però vengono istanziate tutte le classi e non solo quelle realmente necessarie

Il sistema è chiuso, non c'è possibilità di modificare il nome dell'hook e la priorità se non deregistrando l'istanza e creandone una nuova.


## Come si potrebbe risolvere

### Soluzione 1

Creare una mappa multidimensionale di configurazione con tutte le classi controller necessarie e come chiave il nome del template a cui associare i controllers.

Esempio:

$default = [
	'Classe_1',
	'Classe_2',
	'Classe_3',
];

$controllers = [
	'home'			=> [
		'Classe_4',
		'Classe_5',
		'Classe_6',
		...
		'Classe_40',
	],
	'front-page'	=> [
		'Classe_4',
		'Classe_6',
		...
		'Classe_40',
	],
	'single'		=> [
		'Classe_5',
		...
		'Classe_40',
	],
];

// Una roba del genere
if ( ! isset( $controllers[ TEMPLATE_NAME ] ) ) {
	return;
}

$controllers[ TEMPLATE_NAME ] = array_merge( $default, $controllers[ TEMPLATE_NAME ] );

foreach ( $controllers[ TEMPLATE_NAME ] as $callback ) {
	$event_manager->add_subscriber( $injector->make( $callback ) );
}

Qui il problema è che la mappa potrebbe crescere nel tempo, per mantenerla il più snella possibile un mappa default è necessaria

### Soluzione 2

Questo sistema invece non prevede diverse mapper per ogni template ma una singola dove ogni elemento definise se essere caricato o meno.

$controllers = [
	'Classe_1',
	'Classe_2' => [
		'load_on'	=> is_home(),
	],
	'Classe_3',
	'Classe_4',
	'Classe_5',
	'Classe_6',
	...
	'Classe_40',
];

foreach ( $controllers as $key => $callback ) {

	if ( is_int( $key ) ) {
		$event_manager->add_subscriber( $injector->make( $callback ) );
		continue;
	}

	if ( isset( $callback['load_on'] && $callback['load_on'] ) ) {
		$event_manager->add_subscriber( $injector->make( $key ) );
	}
}