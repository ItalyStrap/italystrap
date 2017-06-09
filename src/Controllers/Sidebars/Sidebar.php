<?php
/**
 * Sidebar Controller API
 *
 * This class renders the Sidebar output on the registered position.
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Controllers\Sidebars;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

use ItalyStrap\Controllers\Controller;

use ItalyStrap\Event\Subscriber_Interface;
use ItalyStrap\Layout\Layout;

/**
 * The pagination controller class
 */
class Sidebar extends Controller implements Subscriber_Interface  {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked italystrap_after_entry - 10
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		return array(
			// 'hook_name'				=> 'method_name',
			'italystrap_after_content'	=> 'render',
		);
	}

	function __construct( Layout $layout ) {
		$this->layout = $layout;
	}

	/**
	 * Render the output of the controller.
	 */
	public function render() {

		/**
		 * Don't load sidebar on pages that doesn't need it
		 */
		if ( 'full_width' === $this->layout->get_layout_settings() ) {
			/**
			 * This hook is usefull for example when you need to remove the
			 * WooCommerce sidebar on full width page.
			 *
			 * @example
			 * add_action( 'italystrap_full_width_layout', function () {
			 *     remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
			 * }, 10 );
			 */
			do_action( 'italystrap_full_width_layout' );
			return;
		}

		get_sidebar();

		if ( in_array( $this->layout->get_layout_settings(), array(), true ) ) {
			get_sidebar( 'secondary' );
		}
	}
}
