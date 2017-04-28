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

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

use ItalyStrap\Event\Subscriber_Interface;

/**
 * This filter is in beta version
 * Da testare meglio, avuto problemi con WC + Child e template file mancante in parent
 */
/**
 * Class description
 */
class Controller implements Subscriber_Interface {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked italystrap_template_include - 10
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		return array(
			// 'hook_name'							=> 'method_name',
			'italystrap_template_include'	=> array(
				'function_to_add'	=> 'filter',
				'priority'			=> 10,
			),
		);
	}

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

		add_action( 'italystrap_before_loop', function () { echo "<h1>String</h1>"; } );
	
		return $template;
	}
}
