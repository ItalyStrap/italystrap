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

namespace ItalyStrap\Controllers\Headers;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

use ItalyStrap\Controllers\Controller;
use ItalyStrap\Event\Subscriber_Interface;
use ItalyStrap\Navbar\Navbar;
use ItalyStrap\Template\View_Interface;

/**
 * Class description
 */
class Nav_Menu extends Controller implements Subscriber_Interface  {

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
	 * File name for the view
	 *
	 * @var string
	 */
	protected $file_name = 'headers/navbar';

	/**
	 * Init the class
	 *
	 * @param array $theme_mod Class configuration array.
	 */
	function __construct( array $theme_mod = array(), View_Interface $view, Navbar $navbar  ) {

		$this->data['navbar'] = $navbar;

		parent::__construct( $theme_mod, $view );
	}
}
