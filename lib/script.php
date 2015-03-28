<?php
/**
 * Use this file for loading any scripts and styles
 * If you use child theme copy it in child folder and change $path if necessary
 */
function italystrap_add_style_and_script(){

	/**
	 * @variable $path is path for parent template
	 * @variable $pathchild is for child template
	 */
	global $path;
	global $pathchild;

	/**
	 * Load Bootstrap styles
	 */
	wp_enqueue_style( 'bootstrap',  $path . '/css/bootstrap.min.css', null, null, null);

	/**
	 * Deregister jquery from WP
	 */
	wp_deregister_script('jquery');

	/**
	 * Load jquery from google CDN
	 */
	wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js', false, null, true);
	
	/**
	 * If CDN is down load from callback
	 */
	add_filter('script_loader_src', 'italystrap_jquery_local_fallback', 10, 2);
	wp_enqueue_script('jquery');

	/**
	 * Load script JS and CSS with conditional tags
	 */
	if ( is_home() || is_front_page() ){

		wp_enqueue_style( 'home',  $path . '/css/home.css', array('bootstrap'), null, null);
		wp_enqueue_script( 'home', $path . '/js/home.min.js', array('jquery'), null,  true );

	}elseif ( is_singular() ) {

		wp_enqueue_style( 'singular',  $path . '/css/singular.css', array('bootstrap'), null, null);
		wp_enqueue_script( 'singular', $path . '/js/singular.min.js', array('jquery'), null,  true );

	}elseif ( is_archive() ) {

		wp_enqueue_style( 'archive',  $path . '/css/archive.css', array('bootstrap'), null, null);
		wp_enqueue_script( 'archive', $path . '/js/archive.min.js', array('jquery'), null,  true );

	}else {

		wp_enqueue_style( 'custom',  $path . '/css/custom.css', array('bootstrap'), null, null);
		wp_enqueue_script( 'custom', $path . '/js/custom.min.js', array('jquery'), null,  true );

	}

	/**
	 * Load comment-reply script
	 */
	if (is_singular() && comments_open() && get_option('thread_comments'))
		wp_enqueue_script('comment-reply');
}

/**
 * http://wordpress.stackexchange.com/a/12450
 * https://github.com/roots/roots/blob/master/lib/scripts.php
 */
function italystrap_jquery_local_fallback($src, $handle = null){

	global $path;
	static $add_jquery_fallback = false;

	if ($add_jquery_fallback) {
		echo '<script>window.jQuery || document.write(\'<script src="' . $path . '/js/jquery.min.js"><\/script>\')</script>' . "\n";
		$add_jquery_fallback = false;
	}

	if ($handle === 'jquery') {
		$add_jquery_fallback = true;
	}

	return $src;
}

/**
 * If is not admin load scripts and styles
 */
if ( !is_admin() ){

	add_action( 'wp_enqueue_scripts', 'italystrap_add_style_and_script' ); 
	add_action( 'wp_footer', 'italystrap_jquery_local_fallback' );
}

/**
 * Add Custom CSS in visual editor
 * @link http://codex.wordpress.org/Function_Reference/add_editor_style
 *
 * Leggere qui perché forse c'è un problema con i font, non prende il path giusto
 * @link http://codeboxr.com/blogs/adding-twitter-bootstrap-support-in-wordpress-visual-editor
 * @link https://www.google.it/search?q=wordpress+add+css+bootstrap+visual+editor&oq=wordpress+add+css+bootstrap+visual+editor&gs_l=serp.3...893578.895997.0.896668.10.10.0.0.0.3.388.1849.0j1j4j2.7.0....0...1c.1.52.serp..8.2.732.wb3nJL89Fxk
 */
function italystrap_add_editor_styles() {

	/**
	 * @todo Background su elementi tipo gallery
	 */
	global $path;
	global $pathchild;
    // add_editor_style( $pathchild . '/css/visual_editor.css' );
    add_editor_style( $pathchild . '/css/bootstrap.min.css' );
    add_editor_style( $pathchild . '/css/admin.css' );

}

if ( is_admin() )
	add_action( 'after_setup_theme', 'italystrap_add_editor_styles' );