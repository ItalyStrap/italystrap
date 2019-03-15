<?php
/**
 * View API: View Class
 *
 * @package ItalyStrap\Views
 *
 * @since 4.0.0
 */

namespace ItalyStrap\Template;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

/**
 * Template Class
 */
class View implements View_Interface {

	private $finder;

	public function __construct( Finder_Interface $finder ) {
		$this->finder = $finder;
	}

	/**
	 * Take a template file, bind the data provided and return the string rendered.
	 *
	 * @param string $template_file Full path for this template file.
	 * @param array  $data
	 *
	 * @return mixed
	 */
	private function render_template( $template_file, array $data = [] ) {

		$storage = \ItalyStrap\Config\Config_Factory::make( $data );

		$renderer = \Closure::bind( function( $template_file ) {
				ob_start();
				include $template_file;
				return ob_get_clean();
			},
			$storage
		);

		return $renderer( $template_file );
	}

	/**
	 * Render a template part into a template
	 *
	 * @param  string|array $slugs The slug name for the generic template.
	 * @param  array        $data
	 *
	 * @return string              Return the file part rendered
	 */
	public function render( $slugs, array $data = [] ) {
		return $this->render_template( $this->finder->getRealPath( $slugs ), $data );
	}

	/**
	 * @param string $slugs
	 * @param array  $data
	 */
	public function output( $slug, array $data = [] ) {
		echo $this->render( $slug, $data );
	}
}
