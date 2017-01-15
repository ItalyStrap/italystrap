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

use ItalyStrap\Admin\Category\Editor as Category_Editor;
use ItalyStrap\Admin\Tinymce\Editor as Text_Editor;
use ItalyStrap\Admin\Metabox\Register as Register_Meta;
use ItalyStrap\Admin\Required_Plugins\Register as Required_Plugins;
use ItalyStrap\Admin\Nav_Menu\Register_Nav_Menu_Edit as Register_Nav_Menu_Edit;

use ItalyStrap\Core\Router\Router;
use ItalyStrap\Core\Router\Controller;

use ItalyStrap\Core\Event\Manager as Event_Manager;

use ItalyStrap\Core\Image\Size as Size;
use ItalyStrap\Core\Init\Init_Theme as Init_Theme;
use ItalyStrap\Core\Navbar\Navbar as Navbar;
use ItalyStrap\Core\Sidebars\Sidebars as Sidebars;
use ItalyStrap\Core\Excerpt\Excerpt as Excerpt;

use ItalyStrap\Core\Layout\Layout;
use ItalyStrap\Core\Templates\Template_Base as Template;

use ItalyStrap\Core\Css\Css;

use ItalyStrap\Customizer\Customizer;

use ItalyStrap\Admin\Upgrade\Update;

/**
 * Load some static files.
 * Beta version.
 *
 * @var array
 */
$autoload_files = array(
	'/vendor/autoload.php',
	'/lib/default-constants.php',
	'/lib/general-functions.php',
	'/lib/images.php',
	'/lib/pointer.php',
	// '/lib/cleanup.php', // Cleanup Headers.
	'/lib/wp-h5bp-htaccess.php', // URL https://github.com/roots/wp-h5bp-htaccess.
	'/lib/schema.php',
	'/lib/password_protection.php', // Function for Post/page password protection Bootstrap style.
	'/lib/wp-sanitize-capital-p.php',
	'/lib/woocommerce.php',
	'/lib/debug.php',
	'/deprecated/deprecated.php', // Deprecated files and functions.
	'/deprecated/pagination.php', // Deprecated
	// '/deprecated/users_meta.php', // Deprecated
	// '/deprecated/script.php',// Deprecated file
	// '/deprecated/tag_cloud.php',
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

$events_manager = new Event_Manager();
$events_manager->add_events_test( $injector->make( '\ItalyStrap\Core\Asset\Asset_Factory' ) );
$events_manager->add_events_test( $injector->make( '\ItalyStrap\Core\Tag_Cloud\Tag_Cloud' ) );

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

$update = new Update( $theme_mods );
$update->register();

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

require( TEMPLATEPATH . '/lib/_init_admin.php' );

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
/**
 * Add link to Theme Options in case ItalyStrap plugin is active
 */
if ( defined( 'ITALYSTRAP_PLUGIN' ) ) {
	/**
	 * Add new voice to theme menu
	 */
	add_action( 'admin_menu', array( $init, 'add_appearance_menu' ) );
	add_action( 'admin_menu', array( $init, 'add_link_to_theme_option_page' ) );
}

/**
 * Layout object
 *
 * @var Layout
 */
$site_layout = new Layout( (array) $theme_mods );
add_action( 'italystrap_theme_loaded', array( $site_layout, 'init' ) );

add_action( 'italystrap_after_content', array( $site_layout, 'get_sidebar' ) );

add_filter( 'italystrap_content_attr', array( $site_layout, 'set_content_class' ), 10, 3 );
add_filter( 'italystrap_sidebar_attr', array( $site_layout, 'set_sidebar_class' ), 10, 3 );
add_filter( 'italystrap_sidebar_secondary_attr', array( $site_layout, 'set_sidebar_secondary_class' ), 10, 3 );

/**
 * Template object
 *
 * @var Template
 */
$template_settings = new Template( (array) $theme_mods );
// add_filter(
// 	'italystrap_template_include',
// 	array( $template_settings, 'filter_template_include' )
// );

/**
 * Questo filtro si trova nei file template per gestire commenti e altro
 */
add_filter( 'italystrap_template_settings', array( $template_settings, 'get_template_settings' ) );

$registered_template_classes = array(
	'\ItalyStrap\Core\Templates\Navbar_Top',
	'\ItalyStrap\Core\Templates\Header_Image',
	'\ItalyStrap\Core\Templates\Nav_Menu',
	'\ItalyStrap\Core\Templates\Breadcrumbs',
	'\ItalyStrap\Core\Templates\Archive_Headline',
	'\ItalyStrap\Core\Templates\Author_Info',
	'\ItalyStrap\Core\Templates\Loop',
	'\ItalyStrap\Core\Templates\Entry',
	'\ItalyStrap\Core\Templates\Title',
	'\ItalyStrap\Core\Templates\Meta',
	'\ItalyStrap\Core\Templates\Preview',
	'\ItalyStrap\Core\Templates\Featured_Image',
	'\ItalyStrap\Core\Templates\Content',
	'\ItalyStrap\Core\Templates\Link_Pages',
	'\ItalyStrap\Core\Templates\Modified',
	'\ItalyStrap\Core\Templates\Edit_Post_Link',
	'\ItalyStrap\Core\Templates\Pager',
	'\ItalyStrap\Core\Templates\Pagination',
	'\ItalyStrap\Core\Templates\None',
	'\ItalyStrap\Core\Templates\Comments',
);

foreach ( $registered_template_classes as $value ) {
	// $events_manager->add_events_test( new $value );
	$events_manager->add_events_test( $injector->make( $value ) );
}

add_action( 'italystrap_footer', array( $template_settings, 'do_footer' ) );
