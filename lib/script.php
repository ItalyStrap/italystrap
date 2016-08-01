<?php
/**
 * Use this file for loading any scripts and styles
 * If you use child theme copy it in child folder and change ITALYSTRAP_PARENT_PATH if necessary
 *
 * @package ItalyStrap
 * @since 1.0.0
 */

/**
 * Init script and style
 */
function italystrap_add_style_and_script() {

	/**
	 * Avoid caching script
	 * @var int
	 */
	$ver = ( WP_DEBUG ) ? rand( 0, 100000 ) : null;

	// $min = ( WP_DEBUG ) ? '' : '.min';
	$min = '.min';

	// echo "<pre>";
	// var_dump( CURRENT_TEMPLATE_SLUG );
	// var_dump( ITALYSTRAP_PARENT_PATH . '/css/home.css' );
	// var_dump( file_exists( STYLESHEETPATH . '/css/home.css' ) );
	// var_dump( file_exists( STYLESHEETPATH . '/css/' . CURRENT_TEMPLATE_SLUG . '.css' ) );
	// echo "</pre>";

	/**
	 * Only for
	 * @link http://www.bootstrapcdn.com/alpha/
	 */
	// wp_register_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha/css/bootstrap.min.css', null, null, null );
	// wp_enqueue_style( 'bootstrap' );

	/**
	 * Load Bootstrap styles
	 */
	// wp_enqueue_style( 'bootstrap',  ITALYSTRAP_PARENT_PATH . '/css/bootstrap.min.css', null, $ver, null );

	/**
	 * Deregister jquery from WP
	 */
	// wp_deregister_script( 'jquery' );

	/**
	 * Load jquery from google CDN
	 */
	// wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js', false, $ver, true );

	/**
	 * If CDN is down load from callback
	 */
	add_filter( 'script_loader_src', 'italystrap_jquery_local_fallback', 10, 2 );
	// wp_enqueue_script( 'jquery' );

	/**
	 * Load script JS and CSS with conditional tags
	 */
	// if ( is_home() || is_front_page() ) {

	// 	wp_enqueue_style( 'home',  ITALYSTRAP_PARENT_PATH . '/css/home.css', array( 'bootstrap' ), $ver, null );
	// 	wp_enqueue_script( 'home', ITALYSTRAP_PARENT_PATH . '/js/home' . $min . '.js', array( 'jquery' ), $ver,  true );

	// } elseif ( is_singular() ) {

	// 	wp_enqueue_style( 'singular',  ITALYSTRAP_PARENT_PATH . '/css/singular.css', array( 'bootstrap' ), $ver, null );
	// 	wp_enqueue_script( 'singular', ITALYSTRAP_PARENT_PATH . '/js/singular' . $min . '.js', array( 'jquery' ), $ver,  true );

	// } elseif ( is_archive() ) {

	// 	wp_enqueue_style( 'archive',  ITALYSTRAP_PARENT_PATH . '/css/archive.css', array( 'bootstrap' ), $ver, null );
	// 	wp_enqueue_script( 'archive', ITALYSTRAP_PARENT_PATH . '/js/archive' . $min . '.js', array( 'jquery' ), $ver,  true );

	// } else {

	// 	wp_enqueue_style( 'custom',  ITALYSTRAP_PARENT_PATH . '/css/custom.css', array( 'bootstrap' ), $ver, null );
	// 	wp_enqueue_script( 'custom', ITALYSTRAP_PARENT_PATH . '/js/custom' . $min . '.js', array( 'jquery' ), $ver,  true );

	// }

	/**
	 * Load comment-reply script
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply', null, null, null, true );


	$config_styles = array(
		// array(
		// 	'handle'	=> 'bootstrap',
		// 	'file'		=> 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha/css/bootstrap.min.css',
		// 	'deps'		=> null,
		// 	'version'	=> $ver,
		// 	'media'		=> null,
		// 	'pre_register'	=> true,
		// ),
		// array(
		// 	'handle'	=> 'bootstrap',
		// 	// 'file'		=> STYLESHEETPATH . '/css/bootstrap.min.css',
		// 	'file'		=> ITALYSTRAP_PARENT_PATH . '/css/bootstrap.min.css',
		// 	'deps'		=> null,
		// 	'version'	=> $ver,
		// 	'media'		=> null,
		// 	// 'load_on'	=> 'is_single',
		// ),
		array(
			'handle'	=> CURRENT_TEMPLATE_SLUG,
			'file'		=> file_exists( STYLESHEETPATH . '/css/' . CURRENT_TEMPLATE_SLUG . '.css' ) ? ITALYSTRAP_PARENT_PATH . '/css/' . CURRENT_TEMPLATE_SLUG . '.css' : ITALYSTRAP_PARENT_PATH . '/css/custom.css',
			// 'deps'		=> array( 'bootstrap' ),
			'version'	=> $ver,
			'media'		=> null,
			// 'load_on'	=> 'is_single',
		),
	);

	$style = new ItalyStrap\Core\Style( $config_styles );
	$style->register();

	$config_scripts = array(
		array(
			'handle'		=> 'jquery',
			'file'			=> 'http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js',
			'deps'			=> false,
			'version'		=> $ver,
			'in_footer'		=> true,
			'pre_register'	=> true,
			'deregister'	=> true, // This will deregister previous registered script.
		),
		array(
			'handle'		=> CURRENT_TEMPLATE_SLUG,
			'file'			=> file_exists( STYLESHEETPATH . '/js/' . CURRENT_TEMPLATE_SLUG . $min . '.js' ) ? ITALYSTRAP_PARENT_PATH . '/js/' . CURRENT_TEMPLATE_SLUG . $min . '.js' : ITALYSTRAP_PARENT_PATH . '/js/custom' . $min . '.js',
			'deps'			=> array( 'jquery' ),
			'version'		=> $ver,
			'in_footer'		=> true,
			// 'load_on'	=> 'is_single',
		),
	);

	$script = new ItalyStrap\Core\Script( $config_scripts );
	$script->register();

	// echo "<pre>";
	// var_dump( $style );
	// var_dump( call_user_func( 'is_page', null ) );
	// echo "</pre>";
}

/**
 * Print fallback if google CDN is out
 *
 * @link http://wordpress.stackexchange.com/a/12450
 * @link https://github.com/roots/roots/blob/master/lib/scripts.php
 *
 * @since 1.0.0
 *
 * @param  string $src    jQuery src if true = $add_jquery_fallback.
 * @param  string $handle Name of handle.
 * @return string         Return jQuery fallback if true = $add_jquery_fallback
 */
function italystrap_jquery_local_fallback( $src, $handle = null ) {

	static $add_jquery_fallback = false;

	if ( $add_jquery_fallback ) {

		echo '<script>window.jQuery || document.write(\'<script src="' . ITALYSTRAP_PARENT_PATH . '/js/jquery.min.js"><\/script>\')</script>' . "\n";
		$add_jquery_fallback = false;

	}

	if ( 'jquery' === $handle )
		$add_jquery_fallback = true;

	return $src;
}

/**
 * Hook into the 'wp_enqueue_scripts' action
 */
add_action( 'wp_enqueue_scripts', 'italystrap_add_style_and_script' );
add_action( 'wp_footer', 'italystrap_jquery_local_fallback' );
