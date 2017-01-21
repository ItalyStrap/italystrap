<?php
/**
 * ItalyStrap Bootstrap File
 *
 * This is the bootstrap file for all core and admin Class and Functions.
 *
 * Da leggere:
 * http://mikejolley.com/2013/12/15/deprecating-plugin-functions-hooks-woocommmerce/
 *
 * @package ItalyStrap
 * @since 4.0.0
 */

namespace ItalyStrap\Core;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

// use ItalyStrap\Admin\Category\Editor as Category_Editor;
// use ItalyStrap\Admin\Tinymce\Editor as Text_Editor;
// use ItalyStrap\Admin\Metabox\Register as Register_Meta;
// use ItalyStrap\Admin\Required_Plugins\Register as Required_Plugins;
use ItalyStrap\Admin\Nav_Menu\Register_Nav_Menu_Edit as Register_Nav_Menu_Edit;

use ItalyStrap\Core\Router\Router;
use ItalyStrap\Core\Router\Controller;

use ItalyStrap\Core\Image\Size as Size;
use ItalyStrap\Core\Init\Init_Theme as Init_Theme;
// use ItalyStrap\Core\Navbar\Navbar as Navbar;
use ItalyStrap\Core\Sidebars\Sidebars as Sidebars;
// use ItalyStrap\Core\Excerpt\Excerpt as Excerpt;

// use ItalyStrap\Core\Layout\Layout;
// use ItalyStrap\Core\Templates\Template_Base as Template;

use ItalyStrap\Core\Css\Css;

use ItalyStrap\Customizer\Customizer;

/**
 * Load some static files.
 * Beta version.
 *
 * @var array
 */
$autoload_files = array(
	'/vendor/autoload.php',
	'/functions/default-constants.php',
	'/functions/general-functions.php',

	'/lib/images.php',
	'/lib/pointer.php',
	'/lib/wp-h5bp-htaccess.php', // URL https://github.com/roots/wp-h5bp-htaccess.

	'/deprecated/deprecated.php', // Deprecated files and functions.
	'/deprecated/pagination.php', // Deprecated
	// '/deprecated/users_meta.php', // Deprecated
	// '/deprecated/script.php',// Deprecated file
	// '/deprecated/tag_cloud.php',
	// '/deprecated/woocommerce.php',
	// '/deprecated/password_protection.php', // Function for Post/page password protection Bootstrap style.
	// '/deprecated/cleanup.php', // Cleanup Headers. Moved to the plugin.
	// '/deprecated/schema.php', // Deprecated
	// '/lib/wp-sanitize-capital-p.php', // Moved to the plugin
	// '/lib/debug.php', // Moved to the plugin
);

foreach ( $autoload_files as $file ) {
	require( TEMPLATEPATH . $file );
}

/**
 * Set the default theme constant
 *
 * @see /lib/default-constant.php
 */
set_default_constant();

add_filter( 'italystrap_has_bootstrap', '__return_true' );

/**
 * Set the default theme config value
 *
 * @var array
 */
$italystrap_defaults = apply_filters( 'italystrap_default_theme_config', require( TEMPLATEPATH . '/config/default.php' ) );

/**
 * Define theme otpion array
 * DEPRECATED
 *
 * @var array
 */
$italystrap_options = get_option( 'italystrap_theme_settings' );

if ( ! isset( $theme_mods ) ) {
	$theme_mods = (array) get_theme_mods();
}

/**
 * Get the customiser settings and merge with defaults
 *
 * @var array
 */
// $theme_mods = wp_parse_args( get_theme_mods(), $italystrap_defaults );
$theme_mods = wp_parse_args_recursive( $theme_mods, $italystrap_defaults );

/**
 * Define CURRENT_TEMPLATE and CURRENT_TEMPLATE_SLUG constant.
 * Make shure Router runs after 99998.
 *
 * @see ItalyStrap\Core\set_current_template()
 */
add_filter( 'template_include', __NAMESPACE__ . '\set_current_template', 99998 );

/**
 * Router
 *
 * @see ItalyStrap\Core\Router\Router::route
 */
add_filter( 'template_include', array( new Router(), 'route' ), 99999, 1 );

/**
 * This filter is in beta version
 * Da testare meglio, avuto problemi con WC + Child e template file mancante in parent
 */
// add_filter( 'italystrap_template_include', array( new Controller(), 'filter' ), 10, 1 );

/**
 * Register image site
 * BETA VERSION
 *
 * @var ItalyStrap
 */
$image_size = new Size( $theme_mods );
add_action( 'after_setup_theme', array( $image_size, 'register' ) );

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
add_action( 'wp_update_nav_menu_item', array( $register_nav_menu_edit, 'update_custom_nav_fields' ), 10, 3 );

/**
 * Edit menu walker.
 */
add_filter( 'wp_edit_nav_menu_walker', array( $register_nav_menu_edit, 'register' ), 10, 2 );
add_action( 'wp_fields_nav_menu_item', array( $register_nav_menu_edit, 'add_new_field' ), 10, 2 );

/**
 * $content_width is a global variable used by WordPress for max image upload sizes
 * and media embeds (in pixels).
 *
 * Example: If the content area is 640px wide,
 * set $content_width = 620; so images and videos will not overflow.
 * Default: 750px is the default ItalyStrap container width.
 */
if ( ! isset( $content_width ) ) {

	$content_width = apply_filters( 'content_width', $theme_mods['content_width'] );
}

/**
 * If function exist init
 */
if ( function_exists( 'register_widget' ) ) {
	$sidebars = new Sidebars();
	add_action( 'widgets_init', array( $sidebars, 'register_sidebars' ) );
}

/**
 * CSS manager.
 *
 * @var Css
 */
$css_manager = new Css( $theme_mods );

/**
 * Output custom CSS to live site.
 */
add_action( 'wp_head' , array( $css_manager, 'css_output' ), 11 );

/**
 * Initialize Customizer Class
 *
 * @var ItalyStrap_Theme_Customizer
 */
$italystrap_customizer = new Customizer( $theme_mods );

/**
 * Setup the Theme Customizer settings and controls...
 */
add_action( 'customize_register' , array( $italystrap_customizer, 'register_init' ), 99 );

// Enqueue live preview javascript in Theme Customizer admin screen.
add_action( 'customize_preview_init' , array( $italystrap_customizer, 'live_preview' ) );

/**
 * Init theme
 *
 * @see in hooks.php file
 * @var object The init obj.
 */
$init = new Init_Theme( $css_manager, $content_width );

/**
 * Theme init
 *
 * @see Class Init()
 */
add_action( 'after_setup_theme', array( $init, 'theme_setup' ) );

require( TEMPLATEPATH . '/lib/_init_admin.php' );
require( TEMPLATEPATH . '/lib/_init.php' );
