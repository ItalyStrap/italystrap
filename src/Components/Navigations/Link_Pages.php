<?php
declare(strict_types=1);

namespace ItalyStrap\Components\Navigations;

/**
 * Class description
 */
class Link_Pages {

	/**
	 * Render the output of the controller.
	 */
	public function render() : string {

		/**
		 * Arguments for wp_link_pages
		 *
		 * @link https://developer.wordpress.org/reference/functions/wp_link_pages/
		 * @var array
		 */
		$args = [
			'echo'		=> false,
		];

		$args = \apply_filters( 'italystrap_wp_link_pages_args', $args );

		return \wp_link_pages( $args );
	}
}
