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

namespace ItalyStrap\Init;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

use ItalyStrap\Config\Config_Interface;
use ItalyStrap\Event\Subscriber_Interface;

use ItalyStrap\Css\Css;

/**
 * Theme init
 */
class Init_Theme implements Subscriber_Interface {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked wp_head - 11
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		return [
			// 'hook_name'							=> 'method_name',
			 'init'	=> 'add_post_type_support',
			// 'after_setup_theme'	=> 'setup',
//			'italystrap_plugin_app_loaded'	=> 'setup',
//			'after_setup_theme'	=> 'setup',
//			'after_setup_theme'				=> 'add_editor_styles',
//			'after_setup_theme'	=> [
//				'function_to_add'	=> 'setup',
//				'priority'			=> PHP_INT_MIN,
//				'accepted_args'		=> null,
//			],
			'italystrap_theme_load'	=> [
				'function_to_add'	=> 'setup',
				'priority'			=> 11,
				'accepted_args'		=> null,
			],
		];
	}

	private $config;
	private $css_manager;
	private $content_width;
	private $theme_supports;
	/**
	 * Init some functionality
	 */
	public function __construct( Config_Interface $config, Css $css_manager ) {

		$this->config = $config;

		$this->css_manager = $css_manager;

		$this->content_width = $this->config->get('content_width');

		$this->theme_supports = (array) $this->config->get('add_theme_support');

//		add_action('wp_footer', function () {
//			d( $this->content_width, $this->config->all() );
//		});
	}

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 * customiz
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	public function setup() {

		/**
		 * Make theme available for translation.
		 */
		load_theme_textdomain( 'italystrap', $this->config->get( 'PARENTPATH' ) . '/lang' );

//		if ( is_child_theme() ) {
//			load_child_theme_textdomain( 'CHILD', $this->config->get( 'CHILDPATH' ) . '/lang' );
//		}

		$this->add_theme_supports( $this->theme_supports );

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
		$custom_background = [
			'wp-head-callback' => [
				$this->css_manager, 'custom_background_cb'
			],
		];
		add_theme_support( 'custom-background', apply_filters( 'custom_background_support', $custom_background ) );

		/**
		 * Per ora la eseguo da qui
		 * in futuro valutare posto migliore
		 */
		$this->add_editor_styles();

		/**
		 * This theme uses wp_nav_menu() in one location.
		 */
		$nav_menus_locations = [
			'main-menu'			=> __( 'Main Menu', 'italystrap' ),
			'secondary-menu'	=> __( 'Secondary Menu', 'italystrap' ),
			'social-menu'		=> __( 'Social Menu', 'italystrap' ),
			'info-menu'			=> __( 'Info Menu', 'italystrap' ),
			'footer-menu'		=> __( 'Footer Menu', 'italystrap' ),
		];
		register_nav_menus( apply_filters( 'register_nav_menu_locations', $nav_menus_locations ) );
	}

	/**
	 * Add post type support
	 * @fire on init
	 */
	public function add_post_type_support() {
		foreach ( $this->config->get( 'post_type_support' ) as $post_type => $features ) {
			add_post_type_support( $post_type, $features );
		}
	}

	/**
	 * Add theme supports
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support
	 *
	 * @param  array $theme_supports An array with theme support list.
	 */
	private function add_theme_supports( array $theme_supports = array() ) {

		foreach ( $theme_supports as $feature => $parameters ) {
			if ( is_string( $parameters ) ) {
				add_theme_support( $parameters );
			} else {
				add_theme_support( $feature, $parameters );
			}
		}
	}

	/**
	 * Add Custom CSS in visual editor
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_editor_style
	 * @link https://developer.wordpress.org/reference/functions/add_editor_style/
	 *
	 * Leggere qui perché forse c'è un problema con i font, non prende il path giusto
	 * @link http://codeboxr.com/blogs/adding-twitter-bootstrap-support-in-wordpress-visual-editor
	 * @link https://www.google.it/search?q=wordpress+add+css+bootstrap+visual+editor&oq=wordpress+add+css+bootstrap+visual+editor&gs_l=serp.3...893578.895997.0.896668.10.10.0.0.0.3.388.1849.0j1j4j2.7.0....0...1c.1.52.serp..8.2.732.wb3nJL89Fxk
	 */
	public function add_editor_styles() {

		$style_url = file_exists( CHILDPATH . '/css/editor-style.css' )
			? STYLESHEETURL . '/css/editor-style.css'
			: TEMPLATEURL . '/css/editor-style.css';

		$arg = apply_filters( 'italystrap_visual_editor_style', array( $style_url ) );

		add_editor_style( $arg );
	}
}
