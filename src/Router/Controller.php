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
 * @package ItalyStrap
 */

namespace ItalyStrap\Router;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

use ItalyStrap\Event\Subscriber_Interface;



	/**
	 * filter_template_include
	 *
	 * @param  array $map Array with .
	 * @return array      Return the template path
	 */
	// public function filter_template_include( $map ) {
	// // 	$new_map = array(
	// // 		// 'single.php'	=> 'full-width.php',
	// // 		'single.php'	=> array( $this, 'do_loop' ),
	// // 	);
	// // var_dump( $map, CURRENT_TEMPLATE );
	// 	$map = array(
	// 		'bbpress.php'	=> array( $this, 'test' ),
	// 		// 'bbpress.php'	=> 'bbpress.php',
	// 	);
	// // var_dump( $map );
	// // 	return $new_map;
	// 	return $map;
	// }
// add_filter(
// 	'italystrap_template_include',
// 	array( $template_settings, 'filter_template_include' )
// );

	/**
	 * Function description
	 *
	 * @param  string $value [description]
	 * @return string        [description]
	 */
	// public function test( $template ) {
	// 	remove_action( 'italystrap_before_entry_content', array( $this, 'meta' ), 20 );

	// 	return $template;
	// }

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
//	function __construct( $argument = null ) {
//		// Code...
//	}

	/**
	 * Filter
	 *
	 * @param array $map
	 * @return array [description]
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
	 * @param $template
	 * @return string        [description]
	 */
	public function content( $template ) {

		add_action( 'italystrap_before_loop', function () { echo "<h1>String</h1>"; } );
	
		return $template;
	}
}
