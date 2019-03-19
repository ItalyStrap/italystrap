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

namespace ItalyStrap\Controllers\Comments;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

use ItalyStrap\Controllers\Controller;
use ItalyStrap\Event\Subscriber_Interface;

/**
 * Class description
 */
class Comments extends Controller implements Subscriber_Interface  {

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
	 */
	public function render() {

		/**
		 * Singular (also the static front-page is a singular)
		 */
		if ( ! is_singular() ) {
			return;
		}

		/**
		 * @link https://codex.wordpress.org/Function_Reference/post_type_supports
		 */
		if ( ! post_type_supports( \get_post_type(), 'comments' ) ) {
			return;
		}

		if ( in_array( 'hide_comments', $this->get_template_settings(), true ) ) {
			return;
		}
		
		/**
		 *  $file = '/comments.php', $separate_comments = false
		 */
		\comments_template();
	}
}
