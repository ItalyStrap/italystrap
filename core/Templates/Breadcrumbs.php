<?php
/**
 * Breadcrumbs Controller API
 *
 * This class renders the Breadcrumbs output on the registered position.
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Core\Templates;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

/**
 * Class description
 */
class Breadcrumbs extends Template_Base implements Subscriber_Interface  {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked 'italystrap_before_loop' - 10
	 *
	 * @return array
	 */
	public static function get_subscribed_hooks() {

		return array(
			// 'hook_name'							=> 'method_name',
			'italystrap_before_loop'	=> 'render',
		);
	}

	/**
	 * Render the output of the controller.
	 */
	public function render() {

		\Italystrap\Core\display_breadcrumbs();
	}
}
