<?php
//Carico gli stili CSS
function italystrap_add_style()
	{
		global $path;
		wp_enqueue_style( 'bootstrap',  $path . '/css/bootstrap.min.css', null, null);
		wp_enqueue_style( 'style',  $path . '/style.css', null, null);
	}
if (!is_admin()) 
	{
		add_action( 'wp_enqueue_scripts', 'italystrap_add_style' ); 
	}

//Carico jquery da google api cdn
function italystrap_add_jquery_googlecdn() 
	{
		wp_deregister_script('jquery');
		wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', false, null, true);
		wp_enqueue_script('jquery');
	}
if (!is_admin())
	{
		add_action('init', 'italystrap_add_jquery_googlecdn');
	}

//Carico gli script JS
function italystrap_add_javascripts() 
	{
		global $path;
		wp_enqueue_script( 'bootstrap', $path . '/js/bootstrap.min.js', null, null,  true );
		//wp_enqueue_script('socialite', $path . '/js/socialite.js', null, null, true);
	}
if (!is_admin()) 
	{
		add_action( 'wp_print_scripts', 'italystrap_add_javascripts' ); 
	}
	
//http://www.emoticode.net/php/add-async-and-defer-to-script-on-wordpress.html
// function defer_parsing_of_js ( $url ) {
	// if ( FALSE === strpos( $url, '.js' ) ) return $url;
	// if ( strpos( $url, 'jquery.js' ) ) return $url;
	// return "$url' async defer";
// }
	// add_filter( 'clean_url', 'defer_parsing_of_js', 11, 1 );
?>