<?php
/**
 * ItalyStrap functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * @link https://codex.wordpress.org/Plugin_API
 *
 * @package ItalyStrap
 * @since 1.0.0
 */

namespace ItalyStrap;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

require( TEMPLATEPATH . '/lib/bootstrap.php' );

/**
 * Function for loading the template.
 *
 * @param  string $file_name The file_name on this function is called.
 */
function italystrap( $file_name = 'content' ) {

	$template_dir = apply_filters( 'italystrap_template_dir', 'templates' );

	require locate_template(
		DIRECTORY_SEPARATOR . $template_dir . DIRECTORY_SEPARATOR . $file_name . '.php'
	);
}

/**
 * Fires once ItalyStrap theme has loaded.
 *
 * @since 2.0.0
 */
do_action( 'italystrap_theme_loaded' );

/**
 * This filter is used to load your php file right after ItalyStrap theme is loaded.
 * The purpose is to have al code in the same scope without using global
 * with variables provided from this theme.
 *
 * Usage example:
 *
 * 1 - First of all you have to have the file/files with some code
 *     that extending this themes functionality in your theme path.
 * 2 - Than you have to activate your theme.
 * 3 - And then see the below example.
 *
 * add_filter( 'italystrap_require_theme_files_path', 'add_your_files_path' );
 *
 * function add_your_files_path( array $arg ) {
 *     return array_merge(
 *                  $arg,
 *                  array( STYLESHEETPATH . 'my-dir/my-file.php' )
 *     );
 * }
 * Important:
 * Remeber that the file you want to load just after ItalyStrap theme
 * has not to be required/included from your theme because
 * you will get an error 'You can't redeclare...'.
 *
 * @since 2.0.0
 *
 * @var array
 */
$theme_files_path = apply_filters( 'italystrap_require_theme_files_path', array() );

if ( ! empty( $theme_files_path ) ) {
	foreach ( (array) $theme_files_path as $key => $theme_file_path ) {
		require( $theme_file_path );
	}
	/**
	 * Fires once ItalyStrap Child theme has loaded.
	 *
	 * @since 2.0.0
	 */
	do_action( 'italystrap_child_theme_loaded' );
}
