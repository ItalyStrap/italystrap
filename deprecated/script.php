<?php
/**
 * This file handle loading scripts
 *
 * @package ItalyStrap
 * @since 1.0.0
 */

namespace ItalyStrap\Core;

use ItalyStrap\Core\Asset\Style as Style;
use ItalyStrap\Core\Asset\Script as Script;

/**
 * Init script and style
 */
function add_style_and_script() {

	$min = '.min';

	/**
	 * Avoid caching script
	 *
	 * @var int
	 */
	$ver = null;

	$suffix = '.min';

	$dev_dir = '';

	if ( WP_DEBUG ) {

		$ver = rand( 0, 100000 );
		// $suffix = '';
		// $dev_dir = 'src/'; // Sistemare il path corretto per i font

	}

	$config_styles = array(
		array(
			'handle'	=> CURRENT_TEMPLATE_SLUG,
			'file'		=>
				file_exists( STYLESHEETPATH . '/css/' . $dev_dir . CURRENT_TEMPLATE_SLUG . '.css' )
				? STYLESHEETURL . '/css/' . $dev_dir . CURRENT_TEMPLATE_SLUG . '.css'
				: STYLESHEETURL . '/css/' . $dev_dir . 'custom.css',
			'version'	=> $ver,
			'media'		=> null,
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
			'deregister'	=> true, // This will deregister previous registered jQuery.
		),
		array(
			'handle'		=> CURRENT_TEMPLATE_SLUG,
			'file'			=>
				file_exists( STYLESHEETPATH . '/js/' . CURRENT_TEMPLATE_SLUG . $min . '.js' )
				? STYLESHEETURL . '/js/' . CURRENT_TEMPLATE_SLUG . $min . '.js'
				: STYLESHEETURL . '/js/custom' . $min . '.js',
			'deps'			=> array( 'jquery' ),
			'version'		=> $ver,
			'in_footer'		=> true,
		),
		array(
			'handle'		=> 'comment-reply',
			'load_on'		=> 'ItalyStrap\Core\is_comment_reply',
		),
	);

	$script = new Script( $config_scripts );
	$script->register();

	/**
	 * If CDN is down load from callback
	 */
	add_filter( 'script_loader_src', __NAMESPACE__ . '\jquery_local_fallback', 10, 2 );
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

		/**
		 * @todo document.write è da sostituire.
		 */
		echo '<script>window.jQuery || document.write(\'<script src="' . TEMPLATEURL . '/js/jquery.min.js"><\/script>\')</script>' . "\n";
		$add_jquery_fallback = false;

	}

	if ( 'jquery' === $handle ) {
		$add_jquery_fallback = true;
	}

	return $src;
}

/**
 * Hook into the 'wp_enqueue_scripts' action
 */
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\add_style_and_script' );
add_action( 'wp_footer', __NAMESPACE__ . '\jquery_local_fallback' );
