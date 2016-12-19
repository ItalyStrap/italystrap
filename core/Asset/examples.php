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
		/**
		 * Only for
		 * @link http://www.bootstrapcdn.com/alpha/
		 */
		// array(
		// 	'handle'	=> 'bootstrap',
		// 	'file'		=> 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha/css/bootstrap.min.css',
		// 	'deps'		=> null,
		// 	'version'	=> $ver,
		// 	'media'		=> null,
		// 	'pre_register'	=> true,
		// ),
		array(
			'handle'	=> CURRENT_TEMPLATE_SLUG,
			'file'		=>
				file_exists( STYLESHEETPATH . '/css/' . $dev_dir . CURRENT_TEMPLATE_SLUG . '.css' )
				? STYLESHEETURL . '/css/' . $dev_dir . CURRENT_TEMPLATE_SLUG . '.css'
				: STYLESHEETURL . '/css/' . $dev_dir . 'custom.css',
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
			'deregister'	=> true, // This will deregister previous registered jQuery.
		),
		array(
			'handle'		=> CURRENT_TEMPLATE_SLUG,
			'file'			=> file_exists( STYLESHEETPATH . '/js/' . CURRENT_TEMPLATE_SLUG . $min . '.js' ) ? STYLESHEETURL . '/js/' . CURRENT_TEMPLATE_SLUG . $min . '.js' : STYLESHEETURL . '/js/custom' . $min . '.js',
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
}

/**
 * Hook into the 'wp_enqueue_scripts' action
 */
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\add_style_and_script' );
