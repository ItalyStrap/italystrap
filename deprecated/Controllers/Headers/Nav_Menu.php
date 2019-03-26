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

use ItalyStrap\Navbar\Navbar;
use ItalyStrap\Template\View_Interface;

/**
 * Class description
 */
class Nav_Menu  {

	/**
	 * Init the class
	 *
	 * @param array $theme_mod Class configuration array.
	 */
	function __construct( View_Interface $view, Navbar $navbar  ) {
		$this->view = $view;
		$this->navbar = $navbar;
	}

	public function render( $view ) {
		echo $this->view->render( $view, [ 'navbar' => $this->navbar ] );
	}
}
