<?php
/**
 * Template Interface
 *
 * [Long Description.]
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */


namespace ItalyStrap\Controllers;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

interface Controller_Interface {

	/**
	 * Render the output.
	 */
	public function render();
}
