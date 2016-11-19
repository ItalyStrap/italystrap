<?php
/**
 * Define default theme constant
 *
 * Define default constant to use in the theme framework
 *
 * @link [URL]
 * @since 4.0.0
 *
 * @package ItalyStrap\Core
 */

namespace ItalyStrap\Core;

/**
 * Set default constant
 */
function set_default_constant() {

	/**
	 * Define ITALYSTRAP_THEME constant for internal use
	 */
	define( 'ITALYSTRAP_THEME', true );

	/**
	 * Define the name of parent theme
	 */
	define( 'ITALYSTRAP_THEME_NAME', 'ItalyStrap' );

	/**
	 * The version of the theme
	 */
	define( 'ITALYSTRAP_THEME_VERSION', wp_get_theme()->display( 'Version' ) );

	/**
	 * The name of active theme
	 */
	define( 'ITALYSTRAP_CURRENT_THEME_NAME', wp_get_theme()->get( 'Name' ) );

	/**
	 * Define the prefix for internal use
	 */
	define( 'PREFIX', strtolower( ITALYSTRAP_CURRENT_THEME_NAME ) );

	/**
	 * Define the prefix for internal use with underscore
	 */
	define( '_PREFIX', '_' . PREFIX );

	/**
	 * Define parent path directory
	 * Define ITALYSTRAP_CHILD_PATH in your child theme functions.php file
	 * define( 'ITALYSTRAP_CHILD_PATH', get_stylesheet_directory_uri() );
	 */
	// define( 'ITALYSTRAP_PARENT_PATH', get_template_directory_uri() );
	// Var deprecated from 4.0.0.
	// $path = ITALYSTRAP_PARENT_PATH;

	if ( ! defined( 'TEMPLATEURL' ) ) {
		define( 'TEMPLATEURL', get_template_directory_uri() );
	}

	/**
	 * Define child path directory if is active child theme
	 */
	// define( 'ITALYSTRAP_CHILD_PATH', get_stylesheet_directory_uri() );

	if ( ! defined( 'STYLESHEETURL' ) ) {
		define( 'STYLESHEETURL', get_stylesheet_directory_uri() );
	}

	/**
	 * Define Bog Name constant
	 */
	if ( ! defined( 'GET_BLOGINFO_NAME' ) ) {
		define( 'GET_BLOGINFO_NAME', get_option( 'blogname' ) );
	}

	/**
	 * Define Blog Description Constant
	 */
	if ( ! defined( 'GET_BLOGINFO_DESCRIPTION' ) ) {
		define( 'GET_BLOGINFO_DESCRIPTION', get_option( 'blogdescription' ) );
	}

	/**
	 * Define HOME_URL
	 */
	if ( ! defined( 'HOME_URL' ) ) {
		define( 'HOME_URL', get_home_url( null, '/' ) );
	}

	/**
	 * Front page ID get_option( 'page_on_front' );
	 * Home page ID get_option( 'page_for_posts' );
	 */
	if ( ! defined( 'PAGE_ON_FRONT' ) ) {
		define( 'PAGE_ON_FRONT', absint( get_option( 'page_on_front' ) ) );
	}
	if ( ! defined( 'PAGE_FOR_POSTS' ) ) {
		define( 'PAGE_FOR_POSTS', absint( get_option( 'page_for_posts' ) ) );
	}

}

/**
 * Set Current Template Constant
 * Call this constant from after the 'get_header' action.
 *
 * @hooked template_include - 99998
 *
 * @param string $current_template Return the current temlate
 */
function set_current_template( $current_template ) {

	define( 'CURRENT_TEMPLATE', basename( $current_template ) );
	define( 'CURRENT_TEMPLATE_SLUG', str_replace( '.php', '', CURRENT_TEMPLATE ) );

	return $current_template;
}
