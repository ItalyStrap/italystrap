<?php
/**
 * Layout API: Layout Class
 *
 * @package ItalyStrap\Core
 * @since 1.0.0
 *
 * @since 4.0.0 New class definitions
 */

namespace ItalyStrap\Core\Layout;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

use ItalyStrap\Event\Subscriber_Interface;

/**
 * Layout Class
 */
class Layout implements Subscriber_Interface {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked 'italystrap_before_loop' - 20
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		return array(
			// 'hook_name'				=> 'method_name',
			'italystrap_content_attr'	=> array(
				'function_to_add'	=> 'set_content_class',
				'priority'			=> 10,
				'accepted_args'		=> 3
			),
			'italystrap_sidebar_attr'	=> array(
				'function_to_add'	=> 'set_sidebar_class',
				'priority'			=> 10,
				'accepted_args'		=> 3
			),
			'italystrap_sidebar_secondary_attr'	=> array(
				'function_to_add'	=> 'set_sidebar_secondary_class',
				'priority'			=> 10,
				'accepted_args'		=> 3
			),
		);
	}

	/**
	 * Theme mods
	 *
	 * @var array
	 */
	private $theme_mods = array();

	/**
	 * Layout classes for page elements.
	 *
	 * @var array
	 */
	private $classes = array();

	/**
	 * Init the constructor
	 *
	 * @param array $theme_mod Theme mods array.
	 */
	function __construct( array $theme_mod = array() ) {
		$this->theme_mods = $theme_mod;
	}

	/**
	 * Get the ID
	 *
	 * @return int The current content ID
	 */
	public function get_the_ID() {

		if ( is_home() ) {
			return PAGE_FOR_POSTS;
		}

		return get_the_ID();
	
	}

	/**
	 * Init
	 */
	public function init() {

		$this->classes = array(
			'full_width'				=> array(
				'content'			=> $this->theme_mods['full_width'],
				'sidebar'			=> '',
				'sidebar_secondary'	=> '',
			),
			'content_sidebar'			=> array(
				'content'			=> $this->theme_mods['content_class'],
				'sidebar'			=> $this->theme_mods['sidebar_class'],
				'sidebar_secondary'	=> '',
			),
			'content_sidebar_sidebar'	=> array(
				'content'			=> 'col-md-7',
				'sidebar'			=> 'col-md-3',
				'sidebar_secondary'	=> 'col-md-2',
			),
			'sidebar_content_sidebar'	=> array(
				'content'			=> 'col-md-7 col-md-push-3',
				'sidebar'			=> 'col-md-3 col-md-pull-7',
				'sidebar_secondary'	=> 'col-md-2',
			),
			'sidebar_sidebar_content'	=> array(
				'content'			=> 'col-md-7 col-md-push-5',
				'sidebar'			=> 'col-md-3 col-md-pull-7',
				'sidebar_secondary'	=> 'col-md-2 col-md-pull-10',
			),
			'sidebar_content'			=> array(
				'content'			=> $this->theme_mods['content_class'] . '  col-md-push-4',
				'sidebar'			=> $this->theme_mods['sidebar_class'] . '  col-md-pull-8',
				'sidebar_secondary'	=> '',
			),
		);

		$this->schema = array(
			'front-page'	=> is_home() ? 'https://schema.org/WebSite' : 'https://schema.org/Article',
			'page'			=> 'https://schema.org/Article',
			'single'		=> 'https://schema.org/Article',
			'search'		=> 'https://schema.org/SearchResultsPage',
		);

	}

	/**
	 * Get the layout settings
	 *
	 * @return array Return the array with template part settings.
	 */
	public function get_layout_settings() {

		// delete_post_meta( $this->get_the_ID(), '_italystrap_layout_settings', true );
		// delete_post_meta_by_key( '_italystrap_layout_settings' );

		/**
		 * Front page ID get_option( 'page_on_front' ); PAGE_ON_FRONT
		 * Home page ID get_option( 'page_for_posts' ); PAGE_FOR_POSTS
		 */

		$setting = get_post_meta( $this->get_the_ID(), '_italystrap_layout_settings', true );

		/**
		 * Backward compatibility with the front-page template
		 * old PAGE_ON_FRONT === $this->get_the_ID() && empty( $setting ) 
		 */
		if ( \ItalyStrap\Core\is_static_front_page() && empty( $setting ) ) {
			return 'full_width';
		}

		if ( empty( $setting ) ) {
			return 'content_sidebar';
		}

		return $setting;
	}

	/**
	 * Function description
	 *
	 * @param  string $value [description]
	 * @return string        [description]
	 */
	public function set_content_class( $attr, $context, $args ) {

		$attr['class'] = $this->classes[ $this->get_layout_settings() ]['content'];

		if ( isset( $this->schema[ CURRENT_TEMPLATE_SLUG ] ) ) {
			$attr['itemtype'] = $this->schema[ CURRENT_TEMPLATE_SLUG ];
		} else {
			$attr['itemtype'] = 'https://schema.org/WebSite';
		}

		return $attr;
	
	}

	/**
	 * Set sidebar class
	 *
	 * @param  array $attr The sidebar attribute.
	 * @return array       Return the new array
	 */
	public function set_sidebar_class( $attr ) {

		$attr['class'] = $this->classes[ $this->get_layout_settings() ]['sidebar'];
		return $attr;
	
	}

	/**
	 * Set sidebar class
	 *
	 * @param  array $attr The sidebar attribute.
	 * @return array       Return the new array
	 */
	public function set_sidebar_secondary_class( $attr ) {

		$attr['class'] = $this->classes[ $this->get_layout_settings() ]['sidebar_secondary'];
		return $attr;
	
	}
}
