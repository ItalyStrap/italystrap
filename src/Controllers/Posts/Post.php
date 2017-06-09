<?php
/**
 * Entry Controller API
 *
 * This class renders the Entry output on the registered position.
 *
 * The old system was a little bit different, It chooses the file based on post_type:
 *		// $file_type = get_post_type();
 *	 	// d( $file_type, CURRENT_TEMPLATE_SLUG );
 *		// if ( 'single' === CURRENT_TEMPLATE_SLUG ) {
 *		// 	$file_type = 'single';
 *		// }
 *
 *		// if ( 'search' === CURRENT_TEMPLATE_SLUG ) {
 *		// 	$file_type = 'post';
 *		// }
 *
 *		// $file_type = 'post';
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Controllers\Posts;

use ItalyStrap\Controllers\Controller;
use ItalyStrap\Event\Subscriber_Interface;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

/**
 * Class description
 */
class Post extends Controller implements Subscriber_Interface  {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked 'italystrap_entry' - 10
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		return array(
			// 'hook_name'							=> 'method_name',
			'italystrap_entry'	=> 'render',
		);
	}

	/**
	 * File name for the view
	 *
	 * @var string
	 */
	protected $file_name = 'posts/post';
}
