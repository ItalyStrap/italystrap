<?php
/**
 * View Interface
 *
 * @link www.italystrap.com
 * @since 1.0.0
 *
 * @package ItalyStrap\View
 */
declare(strict_types=1);

namespace ItalyStrap\View;

use \ItalyStrap\Config\Config_Interface;

interface View_Interface {

	/**
	 * Render a template part into a template
	 *
	 * @param  string|array $slugs The slug name for the generic template.
	 * @param  array|Config_Interface $data
	 *
	 * @return string              Return the file part rendered
	 */
	public function render( $slugs, $data = [] ): string;
}
