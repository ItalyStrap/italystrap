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

namespace ItalyStrap\Controllers\Posts\Parts;

use ItalyStrap\Controllers\Controller;
use ItalyStrap\Event\Subscriber_Interface;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

/**
 * Class description
 */
class Breadcrumbs extends Controller implements Subscriber_Interface  {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked 'italystrap_before_loop' - 10
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		return array(
			// 'hook_name'							=> 'method_name',
			'italystrap_before_loop'	=> 'render',
		);
	}

	/**
	 * Render the output of the controller.
	 */
	public function render() {

		if ( in_array( 'hide_breadcrumbs', $this->get_template_settings(), true ) ) {
			return;
		}

		$args = array(
			'home'	=> '<span class="glyphicon glyphicon-home" aria-hidden="true"></span>',
		);

		do_action( 'do_breadcrumbs', $args );
	}
}
