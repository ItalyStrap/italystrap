# ItalyStrap

## Come nasce ItalyStrap

Nel 2013 nasce come uno starter theme con Bootstrap CSS incluso e il markup di Schema.org con l'idea di imparare direttamente portando avanti un progetto personale.
Già da subito però ho sempre utilizzato il tema stesso come parent theme per avere sempre le ultime novità in tutti i siti che realizzavo.

Questo sistema ha sicuramente dei vantaggi per quanto riguarda gli aggiornamenti ma presenta anche degli svantaggi, il principale è quello della retrocompatibilità, per questo ho lavorato negli anni per renderlo più robusto possibile.

Attualmente sono arrivato ad una versione che mi inizia a piacere (cosa rara viste le volte che l'ho praticamente quasi riscritto).

Di seguito indico più o meno come dovrebbe funzionare.

## Come funziona ItalyStrap

ItalyStrap nel suo complesso cerca di mantenere le funzionalità di base che WordPress ha nel core, quindi in primis il sistema di routing nativo anche se non ottimale, quindi il funzionamento dei template rimane invariato.

Quello che è stato aggiunto invece è una atomizzazione dei template stessi per ridurre la duplicazione del codice che purtroppo succede sviluppando un tema "standard", duplicazione intendo per le varie componenti di un template come ad esempio il titolo, l'immagine, il contenuto ecc.

ItalyStrap è il parent theme che si occupa di inizializzare le funzionalità e fornire varie interfacce per lo sviluppo dei child theme (più back-end), i child theme saranno principalmente dedicati per il front-end.

In aggiunta esiste anche un plugin Advanced Control Manager che aggiunge funzionalità ad ItalyStrap (non le elenco perché fa troppa roba).

## Autoloading

Il tema utilizza l'autoloading standard PSR-4 con composer

Le classi sono istanziate utilizzando Auryn\Injector che si occupa di iniettare al bisogno eventuali dipendenze

Il tutto è gestito da una classe dedicata che si occupa di "caricare" l'intera alberatura tramite un file di configurazione "dependencies.php"

## Come configurare le funzionalità da un child theme

Un altro problema che mi si è presentato è stato quello della configurazione iniziale, ogni progetto è diverso e deve esserci un modo semplice di poter avere differenti configurazioni senza dover tutte le volte usare le funzioni native per registrare o deregistrare funzionalità in modo da rispettare la S di SOLID e non avere file functions.php immensi.

Questo è possibile grazie a vari file di configurazione contenuti nella cartella \config di ItalyStrap che possono essere ereditati dal tema child, inserendo il file di riferimento in child/config viene utilizzata la funzione array_replace_recursive per andare a sostituire o aggiungere parametri necessari al funzionamento del tema.
In questo modo si dovrebbe avere uno sviluppo più ordinato (forse).

In pratica la personalizzazione avviene dal child che si occupa solo di gestire css, js ed eventualmente gestire alcune proprietà o aggiungere funzionalità al customizer.

## Assets

Gli assets (css e js) sono caricati dinamicamente in base al nome file template o un file generico.

custom.css|js è caricato di default se non è presente un eventuale page|single|archive|ecc.php

## Components

Seguento il pattern utilizzato da React i Components si occupano della busines logic per i vari componenti che verranno poi stampati nelle view.

## Views o template parts

Ogni elemento che potenzialmente può essere riutilizzato è stato inserito in un file separato, una view.

Le views sono caricate da una classe specifica Builder::class e un file di configurazione dedicato che determina dove come e quando caricare la view.

L'HTML finale è appeso a diversi hook inseriti nelle view genitore, sistema analogo a WooCommerce, Genesis e Beans.

In ogni view è presente un oggetto $this che è una istanza della classe Config che servirà per "prendere" l'eventuale dato da stampare ( $this->get( 'title' ) )

## Struttura delle view

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