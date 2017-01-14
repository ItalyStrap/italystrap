<?php
/**
 * Comments Controller API
 *
 * This class renders the Comments output on the registered position.
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Core\Templates;

use ItalyStrap\Core\Event\Subscriber_Interface;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

/**
 * Class description
 */
class Comments extends Template_Base implements Subscriber_Interface  {

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

		if ( 'page' !== CURRENT_TEMPLATE_SLUG && 'single' !== CURRENT_TEMPLATE_SLUG ) {
			return null;
		}
	
		comments_template();
	}
}
