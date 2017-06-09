<?php
/**
 * Meta Controller API
 *
 * [Long Description.]
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
class Meta extends Controller implements Subscriber_Interface {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked italystrap_entry_content - 30
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		return array(
			// 'hook_name'							=> 'method_name',
			'italystrap_entry_content'	=> array(
				'function_to_add'	=> 'render',
				'priority'			=> 30,
			),
		);
	}

	/**
	 * File name for the view
	 *
	 * @var string
	 */
	protected $file_name = 'posts/parts/meta';

	/**
	 * Render the output of the controller.
	 */
	public function render() {
		
		if ( ! post_type_supports( $this->get_post_type(), 'entry-meta' ) ) {
			return;
		}

		if ( in_array( 'hide_meta', $this->get_template_settings(), true ) ) {
			return;
		}

		parent::render();
	}
}
