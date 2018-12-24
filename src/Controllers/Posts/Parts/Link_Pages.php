<?php
/**
 * Link_Pages Controller API
 *
 * This class renders the Link_Pages output on the registered position.
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Controllers\Posts\Parts;

use ItalyStrap\Controllers\Controller;
use ItalyStrap\Event\Subscriber_Interface;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

/**
 * Class description
 */
class Link_Pages extends Controller implements Subscriber_Interface  {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hoocked 'italystrap_entry_content' - 20
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		return array(
			// 'hook_name'							=> 'method_name',
			'italystrap_entry_content'	=> array(
				'function_to_add'	=> 'render',
				'priority'			=> 20,
			),
		);
	}

	/**
	 * Render the output of the controller.
	 */
	public function render() {

		if (  ! is_single()  ) {
			return;
		}

		/**
		 * Arguments for wp_link_pages
		 *
		 * @link https://developer.wordpress.org/reference/functions/wp_link_pages/
		 * @var array
		 */
		$args = array(
			'before'	=> '<p class="text-muted lead"><b>' . __( 'Pages:', 'italystrap' ) . '</b>',
			'after'		=> '</p>',
		);
		$args = apply_filters( 'italystrap_wp_link_pages_args', $args );

		wp_link_pages( $args );
	}
}
