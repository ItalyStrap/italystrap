<?php
/**
 * WooCommerce Template API
 *
 * This file add a WooCommerce suport for the theme
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Core\WooCommerce;

use ItalyStrap\Event\Subscriber_Interface;

/**
 * WooCommerce
 */
class WooCommerce implements Subscriber_Interface {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked 'woocommerce_sidebar' - 10
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		return array(
			// 'hook_name'				=> 'method_name',
			'woocommerce_sidebar'	=> 'main_container_end',
		);
	}

	/**
	 * Echo the closed tag
	 */
	public function main_container_end() {
		echo '</div></main>';
		do_action( 'italystrap_after_main' );
	}
}
