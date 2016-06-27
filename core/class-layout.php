<?php
/**
 * Layout API: Layout Class
 *
 * @package ItalyStrap\Core
 * @since 1.0.0
 *
 * @since 4.0.0 New class definitions
 */

namespace ItalyStrap\Core;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

/**
 * Layout Class
 */
class Layout {

	/**
	 * [$var description]
	 *
	 * @var array
	 */
	private $theme_mod = array();

	/**
	 * [__construct description]
	 *
	 * @param [type] $argument [description].
	 */
	function __construct( array $theme_mod = array() ) {
		// Code...
	}

	/**
	 * [get_layout_settings description]
	 *
	 * @return array Return the array with template part settings.
	 */
	public function get_template_settings() {

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

	/**
	 * Function description
	 *
	 * @param  string $value [description]
	 * @return string        [description]
	 */
	public function get_site_layout( $attr, $context, $args ) {

		add_action( 'italystrap_after_content', array( $this, 'get_sidebar' ) );

		if ( 'front-page' === CURRENT_TEMPLATE_SLUG && is_home() === false ) {
			$attr['class'] = 'col-md-12';
			$attr['itemtype'] = 'http://schema.org/Article';
			remove_action( 'italystrap_after_content', array( $this, 'get_sidebar' ) );
			return $attr;
		}
		// else {
		// 	add_action( 'italystrap_after_content', array( $this, 'get_sidebar' ) );
		// }

		// if ( 'home' === CURRENT_TEMPLATE_SLUG ) {
			// $attr['class'] = 'col-md-8';
			// add_action( 'italystrap_after_content', array( $this, 'get_sidebar' ) );
			// return $attr;
		// }

		return $attr;
	
	}

	// add_action( 'genesis_after_content', 'genesis_get_sidebar' );
	/**
	 * Output the sidebar.php file if layout allows for it.
	 *
	 * @since 4.0.0
	 */
	function get_sidebar() {

		$site_layout = 'content-sidebar';

		//* Don't load sidebar on pages that don't need it
		if ( 'full-width' === $site_layout )
			return;

		get_sidebar();

	}

	/**
	 * Page Layout
	 *
	 * @param  string $value [description]
	 * @return string        [description]
	 */
	public function page_layout( $value = '' ) {
	
		
		return;
	}
}
