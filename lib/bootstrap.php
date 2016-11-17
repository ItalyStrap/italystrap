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

use ItalyStrap\Core\Image\Size as Size;
use ItalyStrap\Core\Init\Init_Theme as Init_Theme;
use ItalyStrap\Core\Navbar\Navbar as Navbar;
use ItalyStrap\Core\Sidebars\Sidebars as Sidebars;
use ItalyStrap\Core\Excerpt\Excerpt as Excerpt;
use ItalyStrap\Core\Layout\Layout;
use ItalyStrap\Core\Template\Template;

use ItalyStrap\Customizer\Customizer;

use ItalyStrap\Admin\Upgrade\Update;

/**
 * Load some static files.
 * Beta version.
 *
 * @var array
 */
$files = array(
	'/vendor/autoload.php',
	'/lib/default-constants.php',
	'/lib/general-functions.php',
	'/lib/images.php',
	'/lib/pointer.php',
	// '/lib/cleanup.php', // Cleanup Headers.
	'/lib/script.php',
	'/lib/wp-h5bp-htaccess.php', // URL https://github.com/roots/wp-h5bp-htaccess.
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
$defaults = apply_filters( 'italystrap_default_theme_config', require( TEMPLATEPATH . '/config/default.php' ) );

/**
 * Define theme otpion array
 * DEPRECATED
 *
 * @var array
 */
$italystrap_options = get_option( 'italystrap_theme_settings' );

/**
 * Get the customiser settings and merge with defaults
 *
 * @var array
 */
$theme_mods = wp_parse_args( get_theme_mods(), $defaults );

$update = new Update( $theme_mods );
$update->register();

/**
 * Router
 *
 * @see ItalyStrap\Core\Router\Router::route
 */
add_filter( 'template_include', array( new Router(), 'route' ), 99999, 1 );

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
	 * @see ItalyStrap\Admin\Tinymce\Editor::add_new_format_to_mce()
	 */
	add_filter( 'tiny_mce_before_init', array( $admin_text_editor, 'add_new_format_to_mce' ), 9999, 2 );

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
	add_action( 'cmb2_admin_init', array( $metabox, 'register_layout_settings' ) );

}

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
 * Initialize Customizer Class
 *
 * @var ItalyStrap_Theme_Customizer
 */
$italystrap_customizer = new Customizer( $theme_mods );

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
$navbar = new Navbar( $theme_mods );

$italystrap_excerpt = new Excerpt;

/**
 * Theme init
 *
 * @see Class Init()
 */
add_action( 'after_setup_theme', array( $init, 'theme_setup' ) );

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
add_action( 'italystrap_before_while', array( $template_settings, 'archive_headline' ) );
add_action( 'italystrap_before_loop', array( $template_settings, 'author_info' ) );
add_action( 'italystrap_loop', array( $template_settings, 'do_loop' ) );
add_action( 'italystrap_entry', array( $template_settings, 'do_entry' ) );
add_action( 'italystrap_after_loop', array( $template_settings, 'pagination' ) );
add_action( 'italystrap_content_none', array( $template_settings, 'content_none' ) );
add_action( 'italystrap_after_loop', array( $template_settings, 'comments_template' ) );


/**
 * Header
 *
 * @see  add_top_menu() in general-functions.php
 * @see  get_template_content_header() in general-functions.php
 * @see  Class Navbar in class-navbar.php
 */
add_action( 'italystrap_content_header', __NAMESPACE__ . '\add_top_menu', 10 );
add_action( 'italystrap_content_header', __NAMESPACE__ . '\get_template_content_header', 20 );
add_action( 'italystrap_content_header', array( $navbar, 'output' ), 30 );

/**
 * Content
 *
 * @see display_breadcrumbs()
 */
add_action( 'italystrap_before_loop', __NAMESPACE__ . '\display_breadcrumbs' );


/**
 * Function description
 *
 * @param  string $value [description]
 * @return string        [description]
 */
function post_thumbnail_size( $size, $context ) {

	if ( is_page_template( 'full-width.php' ) ) {
		return 'full-width';
	}

	return $size;

}
add_action( 'italystrap_post_thumbnail_size', __NAMESPACE__ . '\post_thumbnail_size', 10, 2 );

/**
 * FOOTER
 */

/**
 * Footer open markup
 *
 * @param  string $value [description]
 * @return string        [description]
 */
function footer_open_markup( $value = '' ) {

	?><!-- Footer --><footer class="site-footer" itemscope itemtype="http://schema.org/WPFooter"><?php

}
add_action( 'italystrap_before_footer', __NAMESPACE__ . '\footer_open_markup', 9 );

/**
 * Do Footer
 *
 * @param  string $value [description]
 * @return string        [description]
 */
function do_footer( $value = '' ) {

	get_template_part( 'template/part', 'content-footer-widget-area' );
	get_template_part( 'template/part', 'content-footer-colophon' );

}
add_action( 'italystrap_footer', __NAMESPACE__ . '\do_footer' );

/**
 * Footer Close markup
 *
 * @param  string $value [description]
 * @return string        [description]
 */
function footer_close_markup( $value = '' ) {

	?></footer><!-- #footer --><?php

}
add_action( 'italystrap_after_footer', __NAMESPACE__ . '\footer_close_markup', 11 );
