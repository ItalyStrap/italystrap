<?php
/**
 * Featured_Image Controller API
 *
 * This class renders the Featured_Image output on the registered position.
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
class Featured_Image extends Controller implements Subscriber_Interface  {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hoocked 'italystrap_entry_content' - 10
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		return array(
			// 'hook_name'							=> 'method_name',
			'italystrap_entry_content'	=> array(
				'function_to_add'	=> 'render',
				'priority'			=> 10,
			),
		);
	}

	/**
	 * File name for the view
	 *
	 * @var string
	 */
	protected $file_name = 'posts/parts/featured-image';

	/**
	 * Render the output of the controller.
	 */
	public function render() {

		/**
		 * @link https://codex.wordpress.org/Function_Reference/post_type_supports
		 */
		if ( ! \post_type_supports( \get_post_type(), 'thumbnail' ) ) {
			return;
		}

		if ( in_array( 'hide_thumb', $this->get_template_settings(), true ) ) {
			return;
		}

		$config = \ItalyStrap\Factory\get_config();

		if ( is_singular() ) {
			$config->push( 'post_thumbnail_size', 'post-thumbnail' );
			$config->push( 'post_thumbnail_alignment', 'aligncenter' );
		}

		$this->data = \ItalyStrap\Factory\get_config();

		parent::render();
	}
}
