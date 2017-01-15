<?php
/**
 * Archive_Headline Controller API
 *
 * This class renders the Archive_Headline output on the registered position.
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
 * The pagination controller class
 */
class Archive_Headline extends Template_Base implements Subscriber_Interface {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked 'italystrap_before_loop' - 20
	 *
	 * @return array
	 */
	public static function get_subscribed_hooks() {

		return array(
			// 'hook_name'				=> 'method_name',
			'italystrap_before_loop'	=> array(
				'function_to_add'	=> 'render',
				'priority'			=> 20,
			),
		);
	}

	/**
	 * Render the output of the controller.
	 */
	public function render() {

		if ( ! is_archive() && ! is_search() ) {
			return;
		}

		if ( is_author() ) {
			return;
		}
		parent::render();
	}
}
