<?php
/**
 * View Interface
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap\View
 */


namespace ItalyStrap\Views;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

interface View_Interface {

	/**
	 * Get the template_parts file.
	 */
	public function get( $slug, $name = null, $load = false );
}
