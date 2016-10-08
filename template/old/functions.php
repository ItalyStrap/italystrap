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

namespace ItalyStrap\Core;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

use \ItalyStrap\Admin\Customizer;
use \ItalyStrap_Sidebars;
use \ItalyStrapBreadcrumbs;
use \Mobile_Detect;

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
define( '_PREFIX', '_' . strtolower( ITALYSTRAP_CURRENT_THEME_NAME ) );

/**
 * Define parent path directory
 * Define ITALYSTRAP_CHILD_PATH in your child theme functions.php file
 * define( 'ITALYSTRAP_CHILD_PATH', get_stylesheet_directory_uri() );
 */
define( 'TEMPLATEURL', get_template_directory_uri() );
// Var deprecated from 4.0.0.
$path = TEMPLATEURL;

/**
 * Define child path directory if is active child theme
 */
define( 'ITALYSTRAP_CHILD_PATH', get_stylesheet_directory_uri() );

/**
 * Define Bog Name constant
 */
if ( ! defined( 'GET_BLOGINFO_NAME' ) )
	define( 'GET_BLOGINFO_NAME', get_option( 'blogname' ) );

/**
 * Define Blog Description Constant
 */
if ( ! defined( 'GET_BLOGINFO_DESCRIPTION' ) )
	define( 'GET_BLOGINFO_DESCRIPTION', get_option( 'blogdescription' ) );

/**
 * Define HOME_URL
 */
if ( ! defined( 'HOME_URL' ) )
	define( 'HOME_URL', get_home_url( null, '/' ) );

/**
 * Define theme otpion array
 *
 * @var array
 */
$italystrap_options = get_option( 'italystrap_theme_settings' );

/**
 * The customiser optionr of ItalyStrap
 *
 * @var array
 */
$theme_mods = get_theme_mods();

require( TEMPLATEPATH . '/vendor/autoload.php' );

// $injector = new \Auryn\Injector;

/**
 * Mobile Detect CLass
 * Load only if class not exist
 */
if ( ! class_exists( 'Mobile_Detect' ) ) {

	require locate_template( '/includes/Mobile_Detect.php' );
	$detect = new Mobile_Detect;

}

/**
 * Add field for adding glyphicon in menu
 *
 * @var Handle_Custom_Walker_Nav_Menu_Edit
 */
$custom_admin_walker_nav_menu = new \ItalyStrap\Admin\Handle_Custom_Walker_Nav_Menu_Edit();

// add custom menu fields to menu
add_filter( 'wp_setup_nav_menu_item', array( $custom_admin_walker_nav_menu, 'add_custom_nav_fields' ) );
// save menu custom fields
add_action( 'wp_update_nav_menu_item', array( $custom_admin_walker_nav_menu, 'update_custom_nav_fields'), 10, 3 );	
// edit menu walker
add_filter( 'wp_edit_nav_menu_walker', array( $custom_admin_walker_nav_menu, 'edit_nav_menu_walker'), 10, 2 );
add_action( 'wp_fields_nav_menu_item', array( $custom_admin_walker_nav_menu, 'add_new_field' ), 10, 2 );

if ( is_admin() ) {

	$required_plugins = new \ItalyStrap\Admin\Register_Required_Plugins;
	add_action( 'tgmpa_register', array( $required_plugins, 'init' ) );

	/**
	 * Admin functionality
	 */
	$admin_text_editor = new \ItalyStrap\Admin\Admin_Text_Editor;

	add_filter( 'mce_buttons_2', array( $admin_text_editor, 'reveal_hidden_tinymce_buttons' ) );

	/**
	 * Add Next Page Button in First Row
	 */
	add_filter( 'mce_buttons', array( $admin_text_editor, 'break_page_button' ), 1, 2 );

	/**
	 * Admin customizer
	 */
	$metabox = new \ItalyStrap\Admin\Custom_Meta_Box;
	add_action( 'cmb2_admin_init', array( $metabox, 'register_layout_settings' ) );

	/**
	 * Wp Editor in Category description
	 */
	new \ItalyStrapAdminCategoryEditor;
}

/**
 * General Template functions
 */
require locate_template( '/lib/general-functions.php' );

/**
 * Custom function for images.
 */
require locate_template( '/lib/images.php' );

/**
 * Activation options, added pointer for theme instructions.
 */
require locate_template( '/lib/pointer.php' );

/**
 * Cleanup Headers.
 */
require locate_template( '/lib/cleanup.php' );

/**
 * Load all Js and CSS script in theme.
 */
require locate_template( '/lib/script.php' );

/**
 * Add htaccess from HTML5 Boilerplate
 *
 * @link   [<description>]https://github.com/roots/wp-h5bp-htaccess.
 */
require locate_template( '/lib/wp-h5bp-htaccess.php' );

/**
 * Pagination.
 */
require locate_template( '/lib/pagination.php' );

/**
 * Users meta.
 */
require locate_template( '/lib/users_meta.php' );

/**
 * Function for Schema.org and OG.
 */
require locate_template( '/lib/schema.php' );

/**
 * New style for tag cloud
 */
require locate_template( '/lib/tag_cloud.php' );

/**
 * Function for Post/page password protection Bootstrap style
 */
require locate_template( '/lib/password_protection.php' );

require locate_template( '/lib/wp-sanitize-capital-p.php' );

require locate_template( '/lib/woocommerce.php' );

/**
 * Functions for debugging porpuse
 */
require locate_template( '/lib/debug.php' );

/** *******************************************************************
 * Deprecated files and functions
 ******************************************************************** */

require locate_template( '/deprecated/deprecated.php' );

/********************
 * Set content width
 ********************/

/**
 * $content_width is a global variable used by WordPress for max image upload sizes
 * and media embeds (in pixels).
 *
 * Example: If the content area is 640px wide,
 * set $content_width = 620; so images and videos will not overflow.
 * Default: 848px is the default ItalyStrap container width.
 */
if ( ! isset( $content_width ) ) $content_width = apply_filters( 'content_width', 750 );

/**
 * If function exist init
 */
if ( function_exists( 'register_widget' ) ) {
	$italystrap_sidebars = new ItalyStrap_Sidebars;
	add_action( 'widgets_init', array( $italystrap_sidebars, 'register_sidebars' ) );
}

/**
 * Initialize Customizer Class
 *
 * @var ItalyStrap_Theme_Customizer
 */
$italystrap_customizer = new Customizer;

/**
 * Setup the Theme Customizer settings and controls...
 */
add_action( 'customize_register' , array( $italystrap_customizer, 'register_init' ) );

// Enqueue live preview javascript in Theme Customizer admin screen.
add_action( 'customize_preview_init' , array( $italystrap_customizer, 'live_preview' ) );

// Output custom CSS to live site.
add_action( 'wp_head' , array( $italystrap_customizer, 'css_output' ), 11 );

/**
 * Add new voice to theme menu
 */
add_action( 'admin_menu', array( $italystrap_customizer, 'add_appearance_menu' ) );

/**
 * Add link to Theme Options in case ItalyStrap plugin is active
 */
if ( defined( 'ITALYSTRAP_PLUGIN' ) ) {
	add_action( 'admin_menu', array( $italystrap_customizer, 'add_link_to_theme_option_page' ) );
}

/**
 * Init theme functions
 *
 * @see in hooks.php file
 * @var object The init obj.
 */
$init = new Init_Theme( $content_width );
$navbar = new Navbar;

/**
 * Functions for debugging porpuse
 */
require locate_template( '/lib/hooks.php' );
