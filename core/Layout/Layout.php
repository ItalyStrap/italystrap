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

/**
 * Layout Class
 */
class Layout {

	/**
	 * Theme mods
	 *
	 * @var array
	 */
	private $theme_mods = array();

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
	 * @return int        The current content ID
	 */
	public function get_the_ID() {
	
		if ( is_home() ) {
			return PAGE_FOR_POSTS;
		}

		return get_the_ID();
	
	}

	/**
	 * [get_layout_settings description]
	 *
	 * @return array Return the array with template part settings.
	 */
	public function get_layout_settings() {

		/**
		 * Front page ID get_option( 'page_on_front' ); PAGE_ON_FRONT
		 * Home page ID get_option( 'page_for_posts' ); PAGE_FOR_POSTS
		 */

		// var_dump( PAGE_ON_FRONT );
		// var_dump( get_post_meta( $this->get_the_ID(), '_italystrap_layout_settings', true ) );
		// delete_post_meta( $this->get_the_ID(), '_italystrap_layout_settings', true );
		// delete_post_meta_by_key( '_italystrap_layout_settings' );
		// 
		$setting = get_post_meta( $this->get_the_ID(), '_italystrap_layout_settings', true );

		if ( PAGE_ON_FRONT !== 0 && PAGE_ON_FRONT === $this->get_the_ID() && empty( $setting ) ) {
			$setting = 'full_width';
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

		$attr['class'] = $this->theme_mods['content_class'];
		
		if ( 'full_width' === $this->get_layout_settings() ) {
			$attr['class'] = $this->theme_mods['full_width'];
		}

		if ( 'front-page' === CURRENT_TEMPLATE_SLUG && is_home() === false ) {
			$attr['itemtype'] = 'http://schema.org/Article';
			return $attr;
		}

		if ( 'home' === CURRENT_TEMPLATE_SLUG ) {
			return $attr;
		}

		if ( 'index' === CURRENT_TEMPLATE_SLUG ) {
			return $attr;
		}

		if ( 'page' === CURRENT_TEMPLATE_SLUG ) {
			$attr['itemtype'] = 'http://schema.org/Article';
			return $attr;
		}

		if ( 'single' === CURRENT_TEMPLATE_SLUG ) {
			$attr['itemtype'] = 'http://schema.org/Article';
			return $attr;
		}

		if ( 'search' === CURRENT_TEMPLATE_SLUG ) {
			$attr['itemtype'] = 'http://schema.org/SearchResultsPage';
			return $attr;
		}

		return $attr;
	
	}

	/**
	 * Output the sidebar.php file if layout allows for it.
	 *
	 * @since 4.0.0
	 */
	function get_sidebar() {

		//* Don't load sidebar on pages that doesn't need it
		if ( 'full_width' === $this->get_layout_settings() ) {
			return;
		}

		get_sidebar();

		// get_sidebar( 'secondary' );

	}

	/**
	 * Function description
	 *
	 * @param  string $value [description]
	 * @return string        [description]
	 */
	public function set_sidebar_class( $attr ) {

		$attr['class'] = $this->theme_mods['sidebar_class'];
		return $attr;
	
	}
}
