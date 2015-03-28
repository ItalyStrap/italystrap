<?php
//Funzione per vedere dipendenze e script caricati nel WP-HEAD http://www.targetweb.it/eliminare-script-caricati-nel-wp-head-di-wordpress/

    // add_action('wp_head', 'debug_scripts_queued');
    // add_action('wp_head', 'debug_styles_queued');
    // add_action('init', 'debug_styles_queued');

    

function debug_scripts_queued() {
    global $wp_scripts;
    var_dump($wp_scripts->in_footer);
    // echo "<style>pre{display:none;}</style>";
    echo '<pre> Script trovati in coda'."\r\n";
    foreach ( $wp_scripts->queue as $script ) {
        echo "\r\nScript: ".$script."\r\n";
        $deps = $wp_scripts->registered[$script]->deps;
        if ($deps) {
            echo "Dipende da: ";
            print_r($deps);
        }else{
            echo "Non dipende da nessuno\r\n";
        }
   }
    echo "\r\n</pre>";
}


function debug_styles_queued() {
    global $wp_styles;
    // var_dump($wp_styles->in_footer);
    var_dump($wp_styles);
    // echo "<style>pre{display:none;}</style>";
    echo '<pre> Script trovati in coda'."\r\n";
    foreach ( $wp_styles->queue as $script ) {
        echo "\r\nScript: ".$script."\r\n";
        $deps = $wp_styles->registered[$script]->deps;
        if ($deps) {
            echo "Dipende da: ";
            print_r($deps);
        }else{
            echo "Non dipende da nessuno\r\n";
        }
   }
    echo "\r\n</pre>";
}


// var_dump();

// var_dump($wpdb->queries);