<?php namespace ItalyStrap\Core;
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

use \ItalyStrap\Admin\Customizer;
use \ItalyStrap_Add_Admin_Menu_Custom_Field;
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
define( 'ITALYSTRAP_PARENT_PATH', get_template_directory_uri() );
// Var deprecated from 4.0.0.
$path = ITALYSTRAP_PARENT_PATH;

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
$italystrap_theme_mods = get_theme_mods();

require( TEMPLATEPATH . '/vendor/autoload.php' );

// $injector = new \Auryn\Injector;

/**
 * TGM class for required plugin
 */
if ( is_admin() )
	require locate_template( '/includes/class-tgm-plugin-required.php' );

/**
 * Mobile Detect CLass
 * Load only if class not exist
 */
if ( ! class_exists( 'Mobile_Detect' ) ) {

	require locate_template( '/includes/Mobile_Detect.php' );
	$detect = new Mobile_Detect;

}

if ( is_admin() ){

	/**
	 * Admin functionality
	 */
	new \ItalyStrap\Admin\Admin_Text_editor;

	/**
	 * Admin customizer
	 */
	$metabox = new \ItalyStrap\Admin\Custom_Meta_Box;
	add_action( 'cmb2_admin_init', array( $metabox, 'register_layout_settings' ) );

	/**
	 * Add field for adding glyphicon in menu
	 */
	new ItalyStrap_Add_Admin_Menu_Custom_Field();

	/**
	 * Wp Editor in Category description
	 */
	new \ItalyStrapAdminCategoryEditor;
}

/**
 * Custom function for images.
 */
require locate_template( '/lib/images.php' );

/**
 * General Template functions
 */
require locate_template( '/lib/general-functions.php' );

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
 * Register Custom Gallery:https://github.com/twittem/wp-bootstrap-gallery.
 */
//require locate_template( '/lib/wp_bootstrap_gallery.php' );

/**
 * New gallery.
 */
require locate_template( '/lib/gallery.php' );

/**
 * Relative URL's
 */
require locate_template( '/lib/relative-urls.php' );

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
 * Related Post.
 */
require locate_template( '/lib/related_post.php' );

/**
 * Users meta.
 */
require locate_template( '/lib/users_meta.php' );

/**
 * Function for Schema.org and OG.
 */
require locate_template( '/lib/schema.php' );

/**
 * Custom taxonomy.
 */
require locate_template( '/lib/custom_taxonomy.php' );

/**
 * New style for tag cloud
 */
require locate_template( '/lib/tag_cloud.php' );

/**
 * CSS above the fold
 */
//require locate_template( '/lib/css-above-the-fold.php' );

/**
 * Function for Post/page password protection Bootstrap style
 */
require locate_template( '/lib/password_protection.php' );

/**
 * Some function for make wordpress more secure
 */
require locate_template( '/lib/security.php' );

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
if ( ! isset( $content_width ) ) $content_width = apply_filters( 'content_width', 848 );

/**
 * If function exist init
 */
if ( function_exists( 'register_widget' ) ) {
	$italystrap_sidebars = new ItalyStrap_Sidebars;
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
 * Theme init
 */
class Init_Theme{

	/**
	 * Init some functionality
	 */
	// public function __construct() {

	// 	add_action( 'after_setup_theme', array( $this, 'theme_setup' ) );

	// }

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 * customiz
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	public function theme_setup() {

		/**
		 * Make theme available for translation.
		 */
		load_theme_textdomain( 'ItalyStrap', TEMPLATEPATH . '/lang' );

		/**
		 * Add theme support functionality
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support
		 */

		/**
		 * Add default posts and comments RSS feed links to head.
		 */
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		*/
		add_theme_support( 'post-thumbnails' );

		/**
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		$html5 = array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				);
		add_theme_support( 'html5', apply_filters( 'html5_support', $html5 ) );

		/**
		 * Enable support for title-tag.
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 *
		 * @var array
		 */
		$post_formats = array(
				'aside',
				'image',
				'gallery',
				'link',
				'quote',
				'status',
				'video',
				'audio',
				'chat',
				);
		add_theme_support( 'post-formats', apply_filters( 'post_formats_support', $post_formats ) );

		/**
		 * Custom header value array
		 *
		 * @var array
		 */
		$custom_header = array(
				'default-image'          => '',
				'width'                  => 1140,
				'height'                 => 400,
				'flex-height'            => true,
				'flex-width'             => true,
				'uploads'                => true,
				'random-default'         => false,
				'header-text'            => true,
				'default-text-color'     => '',
				'wp-head-callback'       => '',
				'admin-head-callback'    => '',
				'admin-preview-callback' => '',
				);
		add_theme_support( 'custom-header', apply_filters( 'custom_header_support', $custom_header ) );

		/**
		 * Custom background support
		 *
		 * @link http://codex.wordpress.org/Custom_Backgrounds
		 * @var array
		 * $defaults = array(
		 *      'default-image'          => '',
		 *		'default-repeat'         => 'repeat',
		 *		'default-position-x'     => 'left',
		 *		'default-attachment'     => 'scroll',
		 *		'default-color'          => '',
		 *		'wp-head-callback'       => '_custom_background_cb',
		 *		'admin-head-callback'    => '',
		 *		'admin-preview-callback' => '',
		 * );
		 *
		 * 'wp-head-callback' => null In case is printed from Theme customizer
		 * @see class-italystrap-theme-customizer.php
		 */
		$custom_background = array(
			'wp-head-callback' => 'ItalyStrap\Admin\italystrap_custom_background_cb',
		);
		add_theme_support( 'custom-background', apply_filters( 'custom_background_support', $custom_background ) );

		/**
		 * @since 4.5 WordPress Core
		 * @see https://make.wordpress.org/core/2016/03/22/implementing-selective-refresh-support-for-widgets/
		 */
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * This theme uses wp_nav_menu() in one location.
		 */
		$nav_menus_locations = array(
			'main-menu'			=> __( 'Main Menu', 'ItalyStrap' ),
			'secondary-menu'	=> __( 'Secondary Menu', 'ItalyStrap' ),
			'social-menu'		=> __( 'Social Menu', 'ItalyStrap' ),
			'info-menu'			=> __( 'Info Menu', 'ItalyStrap' ),
			'footer-menu'		=> __( 'Footer Menu', 'ItalyStrap' ),
			);
		register_nav_menus( apply_filters( 'register_nav_menu_locations', $nav_menus_locations ) );

		/**
		 * Size for default template image
		 */
		require locate_template( 'lib/image_size.php' );

		/**
		 * Add support to WooCommerce
		 *
		 * @since 4.0.0
		 */
		add_theme_support( 'woocommerce' );

	}
}

/**
 * Init theme functions
 *
 * @see in hooks.php file
 * @var object The init obj.
 */
$init = new Init_Theme;
$navbar = new Navbar;

/**
 * Functions for debugging porpuse
 */
require locate_template( '/lib/hooks.php' );

/**
 * Da leggere http://mikejolley.com/2013/12/15/deprecating-plugin-functions-hooks-woocommmerce/
 */
function get_layout_settings() {

	/**
	 * Front page ID get_option( 'page_on_front' );
	 * Home page ID get_option( 'page_for_posts' );
	 */

	$id = '';

	if ( is_home() ) {
		$id = get_option( 'page_for_posts' );
	} else {
		$id = get_the_ID();
	}

	return get_post_meta( $id, '_italystrap_layout_settings', true );
}
add_filter( 'italystrap_layout_settings', __NAMESPACE__ . '\get_layout_settings' );
