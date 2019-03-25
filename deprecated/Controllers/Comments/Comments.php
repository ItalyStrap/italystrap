<?php
/**
 * Comments Controller API
 *
 * This class renders the Comments output on the registered position.
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Controllers\Comments;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

use ItalyStrap\Controllers\Controller;

/**
 * Class description
 */
class Comments extends Controller  {

	/**
	 * Render the output of the controller.
	 */
	public function render() {

//		if ( \in_array( 'hide_comments', $this->get_template_settings(), true ) ) {
//			return;
//		}
		
		/**
		 *  $file = '/comments.php', $separate_comments = false
		 */
		\comments_template();
	}
}
