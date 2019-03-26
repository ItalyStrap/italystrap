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

use \ItalyStrap\Config\Config_Interface;

interface View_Interface {

	/**
	 * Render a template part into a template
	 *
	 * @param  string|array $slugs The slug name for the generic template.
	 * @param  array|Config_Interface $data
	 *
	 * @return string              Return the file part rendered
	 * @throws \Exception
	 */
	public function render( $slugs, $data = [] ) : string;

	/**
	 * Print the redered template.
	 *
	 * @param $slugs
	 * @param array|Config_Interface $data
	 * @throws \Exception
	 */
	public function output( $slugs, $data = [] );
}
