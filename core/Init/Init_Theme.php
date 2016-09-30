<?php
/**
 * [Short Description (no period for file headers)]
 *
 * [Long Description.]
 *
 * @link [URL]
 * @since [x.x.x (if available)]
 *
 * @package [Plugin/Theme/Etc]
 */

namespace ItalyStrap\Core\Init;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

/**
 * Theme init
 */
class Init_Theme{

	/**
	 * Init some functionality
	 */
	public function __construct( $content_width ) {

		$this->content_width = $content_width;

		// add_action( 'after_setup_theme', array( $this, 'theme_setup' ) );

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
		 * 'post-thumbnails' is by default the size displayed for posts, pages and all archives.
		 */
		set_post_thumbnail_size( $this->content_width, 9999 );

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
