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

namespace ItalyStrap\Controllers\Footers;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

use ItalyStrap\Controllers\Controller;
use ItalyStrap\Event\Subscriber_Interface;
use ItalyStrap\View\View_Interface as View;

/**
 * Class description
 */
class Widget_Area extends Controller implements Subscriber_Interface {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked 'italystrap_footer' - 10
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		return array(
			// 'hook_name'							=> 'method_name',
			'italystrap_footer'	=> array(
				'function_to_add'	=> 'render',
				'priority'			=> 10,
			),
		);
	}

	/**
	 * File name for the view
	 *
	 * @var string
	 */
	protected $file_name = 'footers/widget-area';

	/**
	 * Init the class
	 *
	 * @param array $theme_mod Class configuration array.
	 */
	function __construct( array $theme_mod = array(), View $view ) {

		$this->data['footer_sidebars'] = apply_filters(
			'footer_sidebars_widgets',
			array(
				'footer-box-1',
				'footer-box-2',
				'footer-box-3',
				'footer-box-4',
			)
		);

		// $this->data['col'] = $this->set_col();

		parent::__construct( $theme_mod, $view );
	}

	/**
	 * Render the output of the controller.
	 */
	public function render() {

		// $this->footer_sidebars = apply_filters(
		// 	'footer_sidebars_widgets',
		// 	array(
		// 	'footer-box-1',
		// 	'footer-box-2',
		// 	'footer-box-3',
		// 	'footer-box-4',
		// 	)
		// );

		$this->data['col'] = $this->set_col();

		parent::render();
	}

	/**
	 * Set col-x number for sidebars style
	 *
	 * @see footer.php The file to display footer
	 */
	public function set_col() {

		global $sidebars_widgets, $wp_registered_widgets, $wp_registered_widget_controls;

		$count = 0;

		foreach ( $this->data['footer_sidebars'] as $value ) {

			if ( ! empty( $sidebars_widgets[ $value ][0] ) ) {

				$count++;
			}
		}

		$count = ( 0 === $count ) ? 1 : $count ;

		return $col = floor( 12 / $count );
	}
}
