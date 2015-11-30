<?php namespace ItalyStrap;
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
 * Define parent path directory
 * Define ITALYSTRAP_CHILD_PATH in your child theme functions.php file
 * define( 'ITALYSTRAP_CHILD_PATH', get_stylesheet_directory_uri() );
 */
define( 'ITALYSTRAP_PARENT_PATH', get_template_directory_uri() );

// Var deprecated from 3.0.6.
$path = ITALYSTRAP_PARENT_PATH;

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
 * @var array
 */
$italystrap_options = get_option( 'italystrap_theme_settings' );

/**
 * The customiser optionr of ItalyStrap
 * @var array
 */
$italystrap_theme_mods = get_theme_mods();

/*********************************************************************
 *
 * Required external class
 *
 *********************************************************************/

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

/*********************************************************************
 *
 * Start Admins functionality, don't touch that, extend the class instead
 *
 *********************************************************************/

/**
 * Admin Options Theme
 */
require locate_template( '/admin/ItalyStrapOptionTheme.php' );

/**
 * Admin functionality
 */
require locate_template( '/admin/ItalyStrapAdmin.php' );

/**
 * Admin customizer
 */
require locate_template( '/admin/class-italystrap-theme-customizer.php' );
/**
 * Initialize Customizer Class
 * @var ItalyStrap_Theme_Customizer
 */
$italystrap_customizer = new Customizer;

/**
 * Add field for adding glyphicon in menu
 */
require locate_template( '/admin/class-italystrap-admin-menu-custom-field.php' );
	new ItalyStrap_Add_Admin_Menu_Custom_Field();

/**
 * Wp Editor in Category description
 */
require locate_template( '/admin/class-italystrap-category-editor.php' );

/*******************************************************************
 *
 * Start Core functionality, don't touch that, extend class instead
 *
 *******************************************************************/

/**
 * Load custom walker menu class file
 */
require locate_template( 'core/class-italystrap-navwalker.php' );

/**
 * Add new Class for Breadcrumbs
 */
require locate_template( '/core/ItalyStrapBreadcrumbs.php' );

/**
 * Add analytics script
 */
require locate_template( '/core/analytics.php' );

/**
 * Custom function for images.
 */
require locate_template( '/core/images.php' );

/**
 * Class for template functions
 * Depend of images.php
 * @todo Da mettere a posto, al momento non fa nulla
 */
require locate_template( '/core/class-italystrap-template-functions.php' );

/**
 * Class for Excerpt
 */
require locate_template( '/core/class-italystrap-excerpt.php' );

/**
 * Sidebar class.
 */
require locate_template( '/core/class-italystrap-sidebars.php' );

/**
 * If function exist init
 */
if ( function_exists( 'register_widget' ) )
	$italystrap_sidebars = new ItalyStrap_Sidebars;

/**
 * New class for comments and comments form functionality
 */
require locate_template( '/core/class-italystrap-comments.php' );

/*************************************************************************
 *
 * Start custom functionality, you can touch that, please use child theme
 *
 *************************************************************************/

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
 * Custom Widget.
 */
// require locate_template( '/lib/widget.php' );

/**
 * Add htaccess from HTML5 Boilerplate
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
 * Custom fields.
 */
require locate_template( '/lib/custom_fields.php' );

/**
 * Users meta.
 */
require locate_template( '/lib/users_meta.php' );

/**
 * Custom excerpt_length and more.
 */
require locate_template( '/lib/custom_excerpt.php' );

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
 * Custom shortcode
 */
require locate_template( '/lib/custom_shortcode.php' );

/**
 * Some function for make wordpress more secure
 */
require locate_template( '/lib/security.php' );

require locate_template( '/lib/search-form.php' );

require locate_template( '/lib/wp-sanitize-capital-p.php' );

/**
 * Functions for debugging porpuse
 */
require locate_template( '/lib/debug.php' );

/** *******************************************************************
 * Deprecated files and functions
 ******************************************************************** */

require locate_template( '/deprecated/deprecated.php' );

/**
 * Breadcrumb.
 * @deprecated 2.0.0
 * @deprecated Use new ItalyStrapBreadcrumbs( $defaults );
 * @see ItalyStrapBreadcrumbs( $defaults );
 * require locate_template( '/deprecated/breadcrumb.php' );
 */

/**
 * Sidebar.
 * @deprecated 3.0.6
 * require locate_template( '/deprecated/sidebar.php' );
 */

/**
 * Globals variables for internal use.
 * @deprecated 3.0.6
 * require locate_template( '/deprecated/globals.php' );
 */

/**
 * Function for init load.
 * In this file there are after_setup_theme and $content_width
 * @deprecated 3.0.6
 * require locate_template( '/lib/init.php' );
 */

/**
 * new_get_cancel_comment_reply_link
 * require locate_template( '/lib/comment_reply.php' );
 */

/**
 * Walker comments
 * require locate_template( '/lib/comments.php' );
 */

/*********************************************************************
 * Class init for Theme
 *********************************************************************/

/**
 * Theme init
 */
class ItalyStrap_Init_Theme{

	/**
	 * Init some functionality
	 */
	public function __construct() {

		add_action( 'after_setup_theme', array( $this, 'theme_setup' ) );

	}

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
		load_theme_textdomain( 'ItalyStrap', get_template_directory() . '/lang' );

		/**
		 * Add theme support functionality
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
		 * This theme uses wp_nav_menu() in one location.
		 */
		$nav_menus_locations = array(
			'main-menu' => __( 'Main Menu', 'ItalyStrap' ),
			);
		register_nav_menus( apply_filters( 'register_nav_menu', $nav_menus_locations ) );

		/**
		 * Size for default template image
		 */
		require locate_template( 'lib/image_size.php' );

	}

}

new ItalyStrap_Init_Theme;






/*********************************************************************
 * Standard Functions
 *********************************************************************/

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
 * Echo the ItalyStrap theme version (parent or child if exist)
 * Used in footer
 */
function italystrap_version() {

	$ver = wp_get_theme();

	echo esc_attr( $ver->display( 'Version' ) );

}


/**
 * Display the breadcrumbs
 *
 * @param array $defaults Default array for parameters.
 * @return string Echo breadcrumbs
 */
function display_breadcrumbs( $defaults = array() ) {

	if ( ! class_exists( 'ItalyStrapBreadcrumbs' ) )
		return;

		$defaults = array(
			'home'	=> '<span class="glyphicon glyphicon-home" aria-hidden="true"></span>',
			);

		new ItalyStrapBreadcrumbs( $defaults );

}
add_action( 'content_col_open', __NAMESPACE__ . '\display_breadcrumbs' );

/**
 * Permetto gli shortcode nel widget testo
 */
add_filter( 'widget_text', 'do_shortcode' );
