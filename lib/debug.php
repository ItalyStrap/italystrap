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

// global $wp_filter;
// var_dump($wp_filter);

// http://www.wprecipes.com/list-all-hooked-wordpress-functions
function list_hooked_functions( $tag = false ){

   global $wp_filter;
   if ($tag) {
      $hook[$tag]=$wp_filter[$tag];
      if (!is_array($hook[$tag])) {
          trigger_error("Nothing found for '$tag' hook", E_USER_WARNING);
          return;
      }
  }
  else {
      $hook=$wp_filter;
      ksort($hook);
  }
  echo '<pre>';
  foreach($hook as $tag => $priority){
      echo "<br />&gt;&gt;&gt;&gt;&gt;\t<strong>$tag</strong><br />";
      // ksort($priority);
      foreach($priority as $priority => $function){
          echo $priority;
          foreach($function as $name => $properties) echo "\t$name<br />";
      }
  }
  echo '</pre>';
  return;
}

// list_hooked_functions('body_open');
/**
 * An array with all theme action
 * @var array
 */
$theme_action = array(
    'body_open',
    'wrapper_open',
    'content_container_open',
    'content_col_open',
    'content_col_closed',
    'sidebar_col_open',
    'sidebar_col_closed',
    'content_container_closed',
    'footer_open',
    'footer_container_open',
    'footer_container_closed',
    'footer_closed',
    'wrapper_closed',
    'body_closed',
    );

static $i = 0;

// foreach ($theme_action as $value)
//     if ( !empty( $value ) )
//         add_action( $value, 'italustrap_test_action_theme' );


function italustrap_test_action_theme( $val ){
    
    global $theme_action, $i;
    echo '<div style="height:30px;width:100%;background-color:yellow;border: 2px solid black;margin:10px 0"><p style="text-align:center">' . $val . '</p></div>';
    $i++;

}

// var_dump($i);

// var_dump(get_option( 'stylesheet' ));
// var_dump(get_option( "theme_mods_ItalyStrap" ));
// var_dump(get_theme_mods());

// add_action('wp','My_Test');
function My_Test(){
    var_dump(microtime(true));
    for ($i=1; $i<100; $i++) { get_option('blogdescription'); }
    var_dump(microtime(true));
    for ($i=1; $i<100; $i++) { get_theme_mod('blogdescription'); }
    var_dump(microtime(true));
    exit;
}   