<?php
/**
 * ItalyStrap Bootstrap File
 *
 * This is the bootstrap file for all core and admin Class and Functions.
 *
 * @package ItalyStrap
 * @since 4.0.0
 */

namespace ItalyStrap\Core;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

use ItalyStrap\Admin\Category\Editor as Category_Editor;
use ItalyStrap\Admin\Tinymce\Editor as Text_Editor;
use ItalyStrap\Admin\Metabox\Register as Register_Meta;
use ItalyStrap\Admin\Required_Plugins\Register as Required_Plugins;
use ItalyStrap\Admin\Nav_Menu\Register_Nav_Menu_Edit as Register_Nav_Menu_Edit;

use ItalyStrap\Core\Init\Init_Theme as Init_Theme;
use ItalyStrap\Core\Navbar\Navbar as Navbar;
use ItalyStrap\Core\Sidebars\Sidebars as Sidebars;
use ItalyStrap\Core\Excerpt\Excerpt as Excerpt;

use ItalyStrap\Customizer\Customizer;

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
$italystrap_theme_mods = get_theme_mods();

require( TEMPLATEPATH . '/vendor/autoload.php' );

// $injector = new \Auryn\Injector;

/**
 * Add field for adding glyphicon in menu
 *
 * @var Register_Nav_Menu_Edit
 */
$register_nav_menu_edit = new Register_Nav_Menu_Edit();

/**
 * Add custom menu fields to menu
 */
add_filter( 'wp_setup_nav_menu_item', array( $register_nav_menu_edit, 'add_custom_nav_fields' ) );
/**
 * Save menu custom fields
 */
add_action( 'wp_update_nav_menu_item', array( $register_nav_menu_edit, 'update_custom_nav_fields'), 10, 3 );	

/**
 * edit menu walker
 */
add_filter( 'wp_edit_nav_menu_walker', array( $register_nav_menu_edit, 'register'), 10, 2 );
add_action( 'wp_fields_nav_menu_item', array( $register_nav_menu_edit, 'add_new_field' ), 10, 2 );

if ( is_admin() ) {

	require( TEMPLATEPATH . '/admin/functions.php' );

	$required_plugins = new Required_Plugins;
	add_action( 'tgmpa_register', array( $required_plugins, 'init' ) );

	/**
	 * Admin functionality
	 */
	$admin_text_editor = new Text_Editor;

	add_filter( 'mce_buttons_2', array( $admin_text_editor, 'reveal_hidden_tinymce_buttons' ) );

	/**
	 * Add Next Page Button in First Row
	 */
	add_filter( 'mce_buttons', array( $admin_text_editor, 'break_page_button' ), 1, 2 );

	/**
	 * TinyMCE Editor in Category description
	 */
	$editor = new Category_Editor;

	/**
	 * Add fields to widget areas
	 * The $register_metabox is declared in plugin
	 */
	if ( isset( $register_metabox ) ) {
		add_action( 'cmb2_admin_init', array( $register_metabox, 'register_widget_areas_fields' ) );
	}

	/**
	 * Admin customizer
	 */
	$metabox = new Register_Meta;
	add_action( 'cmb2_admin_init', array( $metabox, 'register_template_settings' ) );
}

$files = array(
	// '/vendor/autoload.php',
	'/lib/general-functions.php',
	// '/lib/hooks.php',
	'/lib/images.php',
	'/lib/pointer.php',
	'/lib/cleanup.php', // Cleanup Headers.
	'/lib/script.php',
	'/lib/wp-h5bp-htaccess.php', // https://github.com/roots/wp-h5bp-htaccess.
	'/lib/pagination.php',
	'/lib/users_meta.php',
	'/lib/schema.php',
	'/lib/tag_cloud.php',
	'/lib/password_protection.php', // Function for Post/page password protection Bootstrap style.
	'/lib/wp-sanitize-capital-p.php',
	'/lib/woocommerce.php',
	'/lib/debug.php',
	'/deprecated/deprecated.php', // Deprecated files and functions.
);

foreach ( $files as $file ) {
	require( TEMPLATEPATH . $file );
}

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
	$sidebars = new Sidebars();
	add_action( 'widgets_init', array( $sidebars, 'register_sidebars' ) );
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
 * Add link to Theme Options in case ItalyStrap plugin is active
 */
if ( defined( 'ITALYSTRAP_PLUGIN' ) ) {
	/**
	 * Add new voice to theme menu
	 */
	add_action( 'admin_menu', array( $italystrap_customizer, 'add_appearance_menu' ) );
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

$italystrap_excerpt = new Excerpt;

/**
 * Functions for debugging porpuse
 */
require locate_template( '/lib/hooks.php' );
