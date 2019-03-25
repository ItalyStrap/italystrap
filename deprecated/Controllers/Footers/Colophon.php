<?php
/**
 * Colophon Controller API
 *
 * [Long Description.]
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Controllers\Footers;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

use ItalyStrap\Controllers\Controller;
use ItalyStrap\Event\Subscriber_Interface;

/**
 * Class description
 */
class Colophon extends Controller implements Subscriber_Interface {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked 'italystrap_footer' - 20
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		return array(
			// 'hook_name'							=> 'method_name',
			self::$mods['colophon_action']	=> array(
				'function_to_add'	=> 'render',
				'priority'			=> self::$mods['colophon_priority'],
			),
		);
	}

	/**
	 * File name for the view
	 *
	 * @var string
	 */
	protected $file_name = 'footers/colophon';

	/**
	 * Render the output of the controller.
	 */
	public function render() {

		if ( empty( $this->theme_mod['colophon'] ) ) {
			return;
		}

		$theme_mods = $this->theme_mod;
		parent::render();
	}
}
