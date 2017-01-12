<?php
/**
 * Edit_Post_Link Controller API
 *
 * This class renders the Edit_Post_Link output on the registered position.
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
 * Class description
 */
class Edit_Post_Link extends Template_Base implements Subscriber_Interface  {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hoocked 'italystrap_after_entry_content' - 20
	 *
	 * @return array
	 */
	public static function get_subscribed_hooks() {

		return array(
			// 'hook_name'							=> 'method_name',
			'italystrap_after_entry_content'	=> array( 'render', 20 ),
		);
	}

	/**
	 * Render the output of the controller.
	 */
	public function render() {

		/**
		 * Arguments for edit_post_link()
		 *
		 * @var array
		 */
		$args = array(
			/* translators: %s: Name of current post */
			'link_text'	=> __( 'Edit<span class="screen-reader-text"> "%s"</span>', 'italystrap' ),
			'before'	=> '<p>',
			'after'		=> '</p>',
			'class'		=> 'btn btn-sm btn-primary', // 4.4.0
		);

		$args = apply_filters( 'italystrap_edit_post_link_args', $args );

		edit_post_link(
			sprintf(
				$args['link_text'],
				get_the_title()
			),
			$args['before'],
			$args['after'],
			null,
			$args['class']
		);
	}
}
