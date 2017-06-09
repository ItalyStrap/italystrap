<?php
/**
 * Pagination Controller API
 *
 * This class renders the pagination output on the registered position.
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Controllers\Posts\Parts;

use ItalyStrap\Controllers\Controller;
use ItalyStrap\Event\Subscriber_Interface;
use ItalyStrap\Pagination\Pagination as BT_Pagination;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

/**
 * The pagination controller class
 */
class Pagination extends Controller implements Subscriber_Interface  {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked italystrap_after_loop - 10
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		return array(
			// 'hook_name'							=> 'method_name',
			'italystrap_after_loop'	=> 'render',
		);
	}

	/**
	 * Render the output of the controller.
	 *
	 * @todo wp-includes\link-template.php 2563
	 *       the_posts_pagination();
	 */
	public function render() {

		if ( is_404() ) {
			return;
		}

		$pagination = new  BT_Pagination( $this->theme_mod );
		$pagination->render();
	}
}
