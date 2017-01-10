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

namespace ItalyStrap\Core\Template;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

/**
 * Class description
 */
class Meta extends Template_Base implements Subscriber_Interface {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @return array
	 */
	public static function get_subscribed_hooks() {

		return array(
			// 'hook_name'							=> 'method_name',
			'italystrap_before_entry_content'	=> array( 'render', 20 ),
		);
	}

	/**
	 * Render the Meta template part
	 *
	 * @hoocked 'italystrap_before_entry_content' - 20
	 */
	// public function render() {

	// 	$this->get_template_part( $this->registered_files_path['meta'] );
	// }
}
