<?php
/**
 * View Interface
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap\View
 */


namespace ItalyStrap\Template;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

interface View_Interface {

	/**
	 * Render a template part into a template
	 *
	 * @param string|array $slugs The slug name for the generic template.
	 * @param array        $data  The data to bind to file.
	 *
	 * @return string            Return the file part rendered
	 */
	public function render( $slugs, array $data = [] );
}
