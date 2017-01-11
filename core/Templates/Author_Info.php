<?php
/**
 * Author_Info Controller API
 *
 * This class renders the Author_Info output on the registered position.
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
 * The pagination controller class
 */
class Author_Info extends Template_Base implements Subscriber_Interface  {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @return array
	 */
	public static function get_subscribed_hooks() {

		return array(
			// 'hook_name'				=> 'method_name',
			'italystrap_before_loop'			=> array( 'render', 20 ),
			'italystrap_after_entry_content'	=> array( 'render_after_content', 30 ),
		);
	}

	/**
	 * Render the output of the controller.
	 */
	public function render() {

		if ( 'author' !== CURRENT_TEMPLATE_SLUG ) {
			return null;
		}

		parent::render();
	}

	/**
	 * Render the output of the controller.
	 */
	public function render_after_content() {

		if ( 'single' !== CURRENT_TEMPLATE_SLUG && 'page' !== CURRENT_TEMPLATE_SLUG ) {
			return;
		}

		parent::render();
	}
}
