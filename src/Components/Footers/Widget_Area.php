<?php
/**
 * Footer_Widget_Area Controller API
 *
 * [Long Description.]
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Components\Footers;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

use \ItalyStrap\Template\View_Interface;

/**
 * Class description
 */
class Widget_Area {

	private $data = [];
	private $view;

	/**
	 * Init the class
	 * @param View_Interface $view
	 */
	function __construct( View_Interface $view ) {
		$this->view = $view;
	}

	/**
	 * Render the output of the controller.
	 * @param $view
	 */
	public function render( $view ) {

		$this->data['footer_sidebars'] = apply_filters(
			'footer_sidebars_widgets',
			[
				'footer-box-1',
				'footer-box-2',
				'footer-box-3',
				'footer-box-4',
			]
		);

		$this->data['col'] = $this->set_col();

		echo $this->view->render( $view, $this->data );
	}

	/**
	 * Set col-x number for sidebars style
	 *
	 * @see footer.php The file to display footer
	 */
	private function set_col() : int {

		global $sidebars_widgets, $wp_registered_widgets, $wp_registered_widget_controls;

		$count = 0;

		foreach ( $this->data['footer_sidebars'] as $value ) {

			if ( ! empty( $sidebars_widgets[ $value ][0] ) ) {

				$count++;
			}
		}

		$count = ( 0 === $count ) ? 1 : $count ;

		return floor( 12 / $count );
	}
}
