<?php
/**
 * Navbar_Top Controller API
 *
 * This class renders the Navbar_Top output on the registered position.
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Core\Templates;

use ItalyStrap\Events\Subscriber_Interface;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

/**
 * The Navbar_Top controller class
 */
class Navbar_Top extends Template_Base implements Subscriber_Interface  {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @auth_cookie_expired 'italystrap_before_header' - 10
	 *
	 * @return array
	 */
	public static function get_subscribed_hooks() {

		return array(
			// 'hook_name'							=> 'method_name',
			'italystrap_before_header'	=> 'render',
		);
	}

	/**
	 * Render the output of the controller.
	 */
	public function render() {

		if ( ! has_nav_menu( 'info-menu' ) && ! has_nav_menu( 'social-menu' ) ) {
			return;
		}
		parent::render();
	}
}
