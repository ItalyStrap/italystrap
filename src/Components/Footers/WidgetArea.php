<?php
declare(strict_types=1);

namespace ItalyStrap\Components\Footers;

use \ItalyStrap\View\ViewInterface;

/**
 * @deprecated
 */
class WidgetArea {

	private $data = [];
	private $view;

	/**
	 * Init the class
	 * @param ViewInterface $view
	 */
	public function __construct( ViewInterface $view ) {
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

		$this->data['col'] = $this->setCol();

		echo $this->view->render( $view, $this->data );
	}

	/**
	 * Set col-x number for sidebars style
	 *
	 * @see footer.php The file to display footer
	 */
	private function setCol(): int {

		global $sidebars_widgets, $wp_registered_widgets, $wp_registered_widget_controls;

		$count = 0;

		foreach ( $this->data['footer_sidebars'] as $value ) {
			if ( ! empty( $sidebars_widgets[ $value ][0] ) ) {
				$count++;
			}
		}

		$count = ( 0 === $count ) ? 1 : $count ;

		return \intval( \floor( 12 / $count ) );
	}
}
