<?php
/**
 * This file handle loading scripts
 *
 * @package ItalyStrap
 * @since 1.0.0
 */

namespace ItalyStrap\Core;

/**
 * Init script and style
 */
function add_style_and_script() {

	/**
	 * Avoid caching script
	 * @var int
	 */
	$ver = ( WP_DEBUG ) ? rand( 0, 100000 ) : null;

	// $min = ( WP_DEBUG ) ? '' : '.min';
	$min = '.min';

	/**
	 * Only for
	 * @link http://www.bootstrapcdn.com/alpha/
	 */
	// wp_register_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha/css/bootstrap.min.css', null, null, null );
	// wp_enqueue_style( 'bootstrap' );

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
		// 	'file'		=> STYLESHEETURL . '/css/bootstrap.min.css',
		// 	'deps'		=> null,
		// 	'version'	=> $ver,
		// 	'media'		=> null,
		// 	// 'load_on'	=> 'is_single',
		// ),
		array(
			'handle'	=> CURRENT_TEMPLATE_SLUG,
			'file'		=> file_exists( STYLESHEETPATH . '/css/' . CURRENT_TEMPLATE_SLUG . '.css' ) ? STYLESHEETURL . '/css/' . CURRENT_TEMPLATE_SLUG . '.css' : STYLESHEETURL . '/css/custom.css',
			// 'deps'		=> array( 'bootstrap' ),
			'version'	=> $ver,
			'media'		=> null,
			// 'load_on'	=> 'is_single',
		),
	);

	$style = new Style( $config_styles );
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
			'file'			=> file_exists( STYLESHEETPATH . '/js/' . CURRENT_TEMPLATE_SLUG . $min . '.js' ) ? STYLESHEETURL . '/js/' . CURRENT_TEMPLATE_SLUG . $min . '.js' : STYLESHEETURL . '/js/custom' . $min . '.js',
			'deps'			=> array( 'jquery' ),
			'version'		=> $ver,
			'in_footer'		=> true,
			// 'load_on'	=> 'is_single',
		),
	);

	$script = new Script( $config_scripts );
	$script->register();

	/**
	 * If CDN is down load from callback
	 */
	add_filter( 'script_loader_src', 'ItalyStrap\Core\jquery_local_fallback', 10, 2 );

	/**
	 * Load comment-reply script
	 */
	if ( is_comment_reply() ) {
		wp_enqueue_script( 'comment-reply', null, null, null, true );
	}
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
function jquery_local_fallback( $src, $handle = null ) {

	static $add_jquery_fallback = false;

	if ( $add_jquery_fallback ) {

		echo '<script>window.jQuery || document.write(\'<script src="' . TEMPLATEURL . '/js/jquery.min.js"><\/script>\')</script>' . "\n";
		$add_jquery_fallback = false;

	}

	if ( 'jquery' === $handle )
		$add_jquery_fallback = true;

	return $src;
}

/**
 * Hook into the 'wp_enqueue_scripts' action
 */
add_action( 'wp_enqueue_scripts', 'ItalyStrap\Core\add_style_and_script' );
add_action( 'wp_footer', 'ItalyStrap\Core\jquery_local_fallback' );
