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

namespace ItalyStrap\Core\Templates;

use ItalyStrap\Event\Subscriber_Interface;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

/**
 * Class description
 */
class Featured_Image extends Template_Base implements Subscriber_Interface  {

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
	protected $file_name = 'loops/type/parts/featured-image';

	/**
	 * Render the output of the controller.
	 */
	public function render() {

		/**
		 * @link https://codex.wordpress.org/Function_Reference/post_type_supports
		 */
		if ( ! post_type_supports( $this->get_post_type(), 'thumbnail' ) ) {
			return;
		}

		if ( in_array( 'hide_thumb', $this->get_template_settings(), true ) ) {
			return;
		}

		if ( is_singular() ) {
			$this->theme_mod['post_thumbnail_size'] = 'post-thumbnail';
			$this->theme_mod['post_thumbnail_alignment'] = 'aligncenter';
		}

		parent::render();
	}
}
