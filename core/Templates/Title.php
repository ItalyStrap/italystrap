<?php
/**
 * Title Controller API
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
class Title extends Template_Base implements Subscriber_Interface {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked italystrap_entry_content - 20
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

		/**
		 * @link https://codex.wordpress.org/Function_Reference/post_type_supports
		 */
		if ( ! post_type_supports( $this->get_post_type(), 'title' ) ) {
			return;
		}

		if ( in_array( 'hide_title', $this->get_template_settings(), true ) ) {
			return;
		}

		parent::render();
	}
}
