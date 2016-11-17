<?php
// Funzione per vedere dipendenze e script caricati nel WP-HEAD http://www.targetweb.it/eliminare-script-caricati-nel-wp-head-di-wordpress/
	// add_action('wp_head', 'debug_scripts_queued');
	// add_action('wp_head', 'debug_styles_queued');
	// add_action('init', 'debug_styles_queued');
function debug_scripts_queued() {
	global $wp_scripts;
	var_dump( $wp_scripts->in_footer );
	// echo "<style>pre{display:none;}</style>";
	echo '<pre> Script trovati in coda'."\r\n";
	foreach ( $wp_scripts->queue as $script ) {
		echo "\r\nScript: ".$script."\r\n";
		$deps = $wp_scripts->registered[ $script ]->deps;
		if ( $deps ) {
			echo 'Dipende da: ';
			print_r( $deps );
		} else {
			echo "Non dipende da nessuno\r\n";
		}
	}
	echo "\r\n</pre>";
}


function debug_styles_queued() {
	global $wp_styles;
	// var_dump($wp_styles->in_footer);
	var_dump( $wp_styles );
	// echo "<style>pre{display:none;}</style>";
	echo '<pre> Script trovati in coda'."\r\n";
	foreach ( $wp_styles->queue as $script ) {
		echo "\r\nScript: ".$script."\r\n";
		$deps = $wp_styles->registered[ $script ]->deps;
		if ( $deps ) {
			echo 'Dipende da: ';
			print_r( $deps );
		} else {
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
function list_hooked_functions( $tag = false, $echo = true ) {

	global $wp_filter;

	$output = '';

	if ( $tag ) {
		$hook[ $tag ] = $wp_filter[ $tag ];

		if ( ! is_array( $hook[ $tag ] ) ) {
			$hook[ $tag ] = array();
			// trigger_error( "Nothing found for '$tag' hook", E_USER_WARNING );
			// return;
		}
	} else {
		$hook = $wp_filter;
		ksort( $hook );
	}
	$output .= '<pre>';
	foreach ( $hook as $tag => $priority ) {
		if ( ! is_array( $priority ) ) {
			continue;
		}
		$output .= "<br />&gt;&gt;&gt;&gt;&gt;\t<strong>$tag</strong><br />";
		ksort( $priority );
		foreach ( $priority as $priority => $function ) {
			$output .= $priority;
			foreach ( $function as $name => $properties ) {
				d( $name );
				$output .= "\t$name<br />";
			}
		}
	}
	$output .= '</pre>';

	if ( ! $echo ) {
		return $output;
	}

	echo $output;
}

// list_hooked_functions('body_open');
/**
 * An array with all theme action
 *
 * @var array
 */
$theme_action = array(
	'body_open',
	'wrapper_open',

	'header_open',
	'header_closed',
	// 'nav_open',
	// 'before_wp_nav_menu',
	// 'after_wp_nav_menu',
	// 'nav_closed',

	'italystrap_before_main',
	'italystrap_before_content',
	'italystrap_before_loop',
	'italystrap_loop',
	'italystrap_after_loop',
	'italystrap_after_content',
	'italystrap_after_main',

	'italystrap_before_while',
	'italystrap_before_entry',
	'italystrap_entry',
	'italystrap_after_entry',
	'italystrap_after_while',
	'italystrap_content_none',

	'italystrap_before_footer',
	'italystrap_footer',
	'italystrap_after_footer',

	'wrapper_closed',
	'body_closed',
	);

static $i = 0;

/**
 * Display the hook in pages
 *
 * @uses current_filter() https://codex.wordpress.org/Function_Reference/current_filter
 * @return string      Print an HTML tag with border and hooks name
 */
function italystrap_test_action_theme() {

	global $i;

	$style = '<style>.filter-container{padding:10px 0 5px;width:100%%;background-color:#777;border: 1px solid black;margin:10px 0; float:left;}</style>';

	printf(
		'<div class="filter-container"><p class="filter-name" style="color:white;font-weight:bold;text-align:center">%s</p>%s</div>',
		// $i = 0 ? $style : '',
		current_filter(),
		list_hooked_functions( current_filter(), false )
	);

	$i++;

}

// add_action( 'after_setup_theme', function () use ( $theme_action ) {
// 	foreach ( $theme_action as $value ) {
// 		add_action( $value, 'italystrap_test_action_theme', 99 );
// 	}
// }, 99 );


// var_dump($theme_action);
// var_dump($i);
// var_dump(get_option( 'stylesheet' ));
// var_dump(get_option( "theme_mods_ItalyStrap" ));
// var_dump(get_theme_mods());
// add_action('wp','My_Test');
function My_Test() {

	var_dump( microtime( true ) );

	for ( $i = 1; $i < 100; $i++ ) {
		get_option( 'blogdescription' );
	}

	var_dump( microtime( true ) );

	for ( $i = 1; $i < 100;$i++ ) {
		get_theme_mod( 'blogdescription' );
	}

	var_dump( microtime( true ) );
	exit;
}

/**
 * Test column in 'the_content'
 * https://digwp.com/2010/03/wordpress-post-content-multiple-columns/
 * @param  string $value [description]
 * @return string        [description]
 */
function render_column( $content ) {
	// if ( is_single() && in_the_loop() && is_main_query() )

	$search = array(
		'<!--start-column-->',
		'<!--end-column-->',
	);

	$replace = array(
		'<div class="row">',
		'</div>',
	);
	
	$content = str_replace( $search, $replace, $content );

	$columns = explode( '<!--column-->', $content );
	$count = count( $columns );
// d( $columns );
// d( $content );
	$output = '';
	foreach ( $columns as $key => $column ) {
		$output .= sprintf(
			'<div class="col-md-%s">%s</div>',
			floor( 12 / $count ),
			wpautop( $column )
		);
	}
	// d( $output );
	return $output;
	// return $content;

}
add_action( 'the_content', __NAMESPACE__ . '\render_column', 10, 1 );
remove_filter( 'the_content', 'wpautop', 10 );


// http://php.net/manual/en/function.get-defined-vars.php
// get_defined_vars();
// 
// http://php.net/manual/en/function.get-defined-functions.php
// get_defined_functions();
// 
// http://php.net/manual/en/function.get-defined-constants.php
// get_defined_constants();
