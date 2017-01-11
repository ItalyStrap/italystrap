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


namespace ItalyStrap\Core\Templates;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

interface Template_Interface {

	/**
	 * Render the output.
	 */
	public function render();
}
