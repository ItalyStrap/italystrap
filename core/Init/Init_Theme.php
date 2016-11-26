<?php
/**
 * Theme Init Class
 *
 * This class is under development, consider this an ALPHA version,
 * some functionality can be changed in future, especially the filter name.
 *
 * @link [URL]
 * @since 3.0.5
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Core\Init;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

use ItalyStrap\Core\Css\Css;

/**
 * Theme init
 */
class Init_Theme{

	/**
	 * $capability
	 *
	 * @var string
	 */
	private $capability = 'edit_theme_options';

	/**
	 * Init some functionality
	 */
	public function __construct( Css $css_manager, $content_width ) {

		$this->css_manager = $css_manager;

		$this->content_width = $content_width;

		// $this->set_theme_mod_from_options();
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
		 * @see ItalyStrap\Core\Css\Css::custom_background_cb()
		 */
		$custom_background = array(
			'wp-head-callback' => array( $this->css_manager, 'custom_background_cb' ),
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
		// require locate_template( 'lib/image_size.php' );

		/**
		 * Add support to WooCommerce
		 *
		 * @since 4.0.0
		 */
		add_theme_support( 'woocommerce' );

	}

	/**
	 * Function for adding link to Theme Options in case ItalyStrap plugin is active
	 *
	 * @link http://snippets.webaware.com.au/snippets/add-an-external-link-to-the-wordpress-admin-menu/
	 * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#focusing
	 * autofocus[panel|section|control]=ID
	 */
	public function add_link_to_theme_option_page() {

		global $submenu;
		/**
		 * Link to customizer
		 *
		 * @link http://wptheming.com/2015/01/link-to-customizer-sections/
		 * @var string
		 */
		$url = admin_url( 'customize.php?autofocus[panel]=italystrap_options_page' );
		$submenu['italystrap-dashboard'][] = array(
			__( 'Theme Options', 'italystrap' ),
			$this->capability,
			$url,
		);
	}

	/**
	 * Add new menu in theme.php
	 */
	public function add_appearance_menu() {

		/**
		 * Add theme page
		 *
		 * @link https://codex.wordpress.org/Function_Reference/add_theme_page
		 */
		add_theme_page(
			__( 'ItalyStrap Theme Info', 'italystrap' ),// $page_title <title></title>
			__( 'ItalyStrap Theme Info', 'italystrap' ),// $menu_title.
			$this->capability,							// $capability.
			'italystrap-theme-info',					// $menu_slug.
			array( $this, 'callback_function' )			// $function.
		);

	}

	/**
	 * Add WordPress standard form for options page
	 */
	public function callback_function() {

		if ( ! current_user_can( $this->capability ) ) {
			wp_die( esc_attr__( 'You do not have sufficient permissions to access this page.', 'italystrap' ) );
		}

		?>

			<div class="wrap">
				<h2>
					<span class="dashicons dashicons-admin-settings" style="font-size:32px;margin-right:15px"></span> ItalyStrap panel
				</h2>
				<form action='options.php' method='post'>
					
					<?php
					settings_fields( 'italystrap_theme_options_group' );
					do_settings_sections( 'italystrap_theme_options_group' );
					submit_button();
					?>
					
				</form>
			</div>

		<?php

	}

	/**
	 * Esporto le opzioni precedentemente registrate in options e le carico nelle opzioni del tema
	 */
	public function set_theme_mod_from_options() {

		/**
		 * Rendo globale la variabile delle opzioni
		 */
		global $italystrap_options;

		if ( ! $italystrap_options ) {
			return;
		}

		foreach ( $italystrap_options as $key => $value ) {

			if ( ! get_theme_mod( $key ) && preg_match( '#png|jpg|gif#is', $italystrap_options[ $key ] ) ) {

				set_theme_mod( $key, $this->get_image_id_from_url( $italystrap_options[ $key ] ) );
			} elseif ( ! get_theme_mod( $key ) ) {

				set_theme_mod( $key, $italystrap_options[ $key ] );

			}

			/**
			 * Test
			 * var_dump( $key . ' => ' . get_theme_mod( $key ) );
			 * remove_theme_mod( $key );
			 */

		}

		/**
		 * Test
		 * remove_theme_mod( 'colophon' );
		 * var_dump(get_theme_mods());
		 */
	}

	/**
	 * Retrieves the attachment ID from the file URL
	 *
	 * @link https://pippinsplugins.com/retrieve-attachment-id-from-image-url/
	 * @param  string $image_url The src of the image.
	 * @return int               Return the ID of the image
	 */
	private function get_image_id_from_url( $image_url ) {

		$attachment = wp_cache_get( 'get_image_id' . $image_url );

		if ( false === $attachment ) {

			global $wpdb;
			$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ) );
			wp_cache_set( 'get_image_id' . $image_url, $attachment );
		}

		$attachment[0] = ( isset( $attachment[0] ) ) ? $attachment[0] : null;

		return absint( $attachment[0] );

	}
}
