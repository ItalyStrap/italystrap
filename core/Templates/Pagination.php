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

namespace ItalyStrap\Core\Templates;

use ItalyStrap\Core\Event\Subscriber_Interface;
use ItalyStrap\Core\Pagination\Pagination;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

/**
 * The pagination controller class
 */
class Pagination extends Template_Base implements Subscriber_Interface  {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked italystrap_after_loop - 10
	 *
	 * @return array
	 */
	public static function get_subscribed_hooks() {

		return array(
			// 'hook_name'							=> 'method_name',
			'italystrap_after_loop'	=> 'render',
		);
	}

	/**
	 * Render the output of the controller.
	 */
	public function render() {
		$pagination = new Pagination( $this->theme_mod );
		$pagination->render();
	}
}