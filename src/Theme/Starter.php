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

namespace ItalyStrap\Theme;

use ItalyStrap\Config\Config_Interface;
use ItalyStrap\Event\Subscriber_Interface;

/**
 * Theme init
 */
class Starter implements Subscriber_Interface {

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
			'italystrap_theme_load'	=> [
				'function_to_add'		=> 'start',
				'priority'				=> 20,
			],
			'init'					=> 'start',
			'widgets_init'			=> 'start',
		];
	}

	private $config;
	private $thumbnails;
	private $support;
	private $type_support;
	private $nav_menus;

	/**
	 * @var Sidebars
	 */
	private $sidebars;

	/**
	 * Init some functionality
	 * @param Config_Interface $config
	 * @param Thumbnails $thumbnails
	 * @param Sidebars $sidebars
	 * @param Support $support
	 * @param Type_Support $type_support
	 * @param Nav_Menus $nav_menus
	 */
	public function __construct(
		Config_Interface $config,
		Thumbnails $thumbnails,
		Sidebars $sidebars,
		Support $support,
		Type_Support $type_support,
		Nav_Menus $nav_menus
	) {
		$this->config = $config;
		$this->thumbnails = $thumbnails;
		$this->sidebars = $sidebars;
		$this->support = $support;
		$this->type_support = $type_support;
		$this->nav_menus = $nav_menus;
	}

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 * customiz
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	public function start() {
		$method = \current_filter();
		if ( \method_exists( $this, $method ) ) {
			$this->$method();
		}
	}

	/**
	 *
	 */
	private function italystrap_theme_load() {

		/**
		 * Make theme available for translation.
		 */
		\load_theme_textdomain( 'italystrap', $this->config->get( 'PARENTPATH' ) . '/languages' );

//		if ( is_child_theme() ) {
//			\load_child_theme_textdomain( 'CHILD', $this->config->get( 'CHILDPATH' ) . '/languages' );
//		}

		$this->support->register();

		$this->thumbnails->register();

		$this->nav_menus->register();

		/**
		 * Per ora la eseguo da qui
		 * in futuro valutare posto migliore
		 */
		$this->add_editor_styles();
	}

	/**
	 * Register al sidebars
	 */
	private function widgets_init() {
		$this->sidebars->register();
	}

	/**
	 * Add post type support
	 * @fire on init
	 */
	private function init() {
		$this->type_support->register();
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
	private function add_editor_styles() {

		$style_url = file_exists( CHILDPATH . '/css/editor-style.css' )
			? STYLESHEETURL . '/css/editor-style.css'
			: TEMPLATEURL . '/css/editor-style.css';

		$arg = \apply_filters( 'italystrap_visual_editor_style', [ $style_url ] );

		\add_editor_style( $arg );
	}
}
