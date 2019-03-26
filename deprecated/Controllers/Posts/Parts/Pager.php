<?php
/**
 * Pager Controller API
 *
 * This class renders the Pager output on the registered position.
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Controllers\Posts\Parts;

use ItalyStrap\Controllers\Controller;
use ItalyStrap\Event\Subscriber_Interface;
use ItalyStrap\Template\View_Interface;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

/**
 * The pager controller class
 */
class Pager extends Controller implements Subscriber_Interface  {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked italystrap_after_entry - 10
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		return array(
			// 'hook_name'				=> 'method_name',
			'italystrap_after_entry'	=> 'render',
		);
	}

	private $pager;

	public function __construct( View_Interface $view, \ItalyStrap\Components\Navigations\Pager $pager, array $theme_mods = array() ) {
		parent::__construct( $theme_mods, $view );

		$this->pager = $pager;
	}

	/**
	 * Render the output of the controller.
	 */
	public function render() {
		
		if ( ! \post_type_supports( \get_post_type(), 'post_navigation' ) ) {
			return;
		}

		if (  ! is_single()  ) {
			return;
		}

		echo $this->pager->render();
	}
}
