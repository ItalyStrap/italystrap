<?php
/**
 * Content Controller API
 *
 * [Long Description.]
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Core\Templates;

use ItalyStrap\Event\Subscriber_Interface;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

/**
 * Class description
 */
class Content extends Template_Base implements Subscriber_Interface {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked italystrap_entry_content - 50
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		return array(
			// 'hook_name'							=> 'method_name',
			'italystrap_entry_content'	=> array(
				'function_to_add'	=> 'render',
				'priority'			=> apply_filters( 'italystrap_content_priority', 50 ),
			),
		);
	}

	/**
	 * Render the output of the controller.
	 */
	public function render() {

		if ( in_array( 'hide_content', $this->get_template_settings(), true ) ) {
			return;
		}

		parent::render();
	}
}
