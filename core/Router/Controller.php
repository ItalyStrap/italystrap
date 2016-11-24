<?php
/**
 * Controller for router functionality
 *
 * [Long Description.]
 *
 * @link www.italystrap.com
 * @since 4.0.0
 * @beta
 *
 * @package Italystrap
 */

namespace ItalyStrap\Core\Router;

/**
 * Class description
 */
class Controller {

	/**
	 * [$var description]
	 *
	 * @var null
	 */
	private $var = null;

	/**
	 * [__construct description]
	 *
	 * @param [type] $argument [description].
	 */
	function __construct( $argument = null ) {
		// Code...
	}

	/**
	 * Filter
	 *
	 * @param  string $value [description]
	 * @return string        [description]
	 */
	public function filter( array $map ) {

		$map = array(
			CURRENT_TEMPLATE	=> array( $this, 'content' ),
		);

		return $map;
	}

	/**
	 * Content
	 *
	 * @param  string $value [description]
	 * @return string        [description]
	 */
	public function content( $template ) {

		// add_action( 'italystrap_before_loop', function () { echo "<h1>String</h1>"; } );
	
		return $template;
	}
}
