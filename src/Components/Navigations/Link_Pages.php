<?php
/**
 * Link_Pages Controller API
 *
 * This class renders the Link_Pages output on the registered position.
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

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

		$args = apply_filters( 'italystrap_wp_link_pages_args', $args );

		return wp_link_pages( $args );
	}
}
