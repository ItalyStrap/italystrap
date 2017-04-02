<?php
/**
 * Title Controller API
 *
 * [Long Description.]
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

use ItalyStrap\Core\Navbar\Navbar;

/**
 * Class description
 */
class Nav_Menu extends Template_Base implements Subscriber_Interface  {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		return array(
			// 'hook_name'							=> 'method_name',
			'italystrap_after_header'	=> 'render',
		);
	}

	/**
	 * Init the class
	 *
	 * @param array $theme_mod Class configuration array.
	 */
	function __construct( array $theme_mod = array(), Navbar $navbar  ) {

		$this->navbar = $navbar;

		parent::__construct( $theme_mod );
	}

	/**
	 * Function description
	 */
	public function render() {
		$this->navbar->output();
	}
}
