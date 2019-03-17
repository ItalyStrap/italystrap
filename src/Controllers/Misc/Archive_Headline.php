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

namespace ItalyStrap\Controllers\Misc;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

use ItalyStrap\Controllers\Controller;
use ItalyStrap\Event\Subscriber_Interface;

/**
 * The pagination controller class
 */
class Archive_Headline extends Controller implements Subscriber_Interface {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked 'italystrap_before_loop' - 20
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		return array(
			// 'hook_name'				=> 'method_name',
			'italystrap_before_while'	=> array(
				'function_to_add'	=> 'render',
				'priority'			=> 20,
			),
		);
	}

	/**
	 * File name for the view
	 *
	 * @var string
	 */
	protected $file_name = 'misc/archive-headline';

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
