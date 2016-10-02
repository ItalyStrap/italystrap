<?php
/**
 * Initialize custom meta box build with CMB2
 *
 * @package ItalyStrap\Admin
 *
 * @version 1.0
 * @since   4.0.0
 */

namespace ItalyStrap\Admin\Tinymce;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

/**
 * Improve WordPress text editor
 */
class Editor {

	/**
	 * The following snippet will reveal the hidden
	 * "Styles" dropdown in the advanced toolbar.
	 *
	 * @link http://codex.wordpress.org/Plugin_API/Filter_Reference/mce_buttons,_mce_buttons_2,_mce_buttons_3,_mce_buttons_4
	 *
	 * @since 1.9.2
	 *
	 * @param  array $buttons Array with WP editor buttons registered.
	 *
	 * @return array          Array with new buttons.
	 */
	public function reveal_hidden_tinymce_buttons( $buttons ) {

		/**
		 * Add style selector to the beginning of the toolbar
		 */
		array_unshift( $buttons, 'styleselect' );

		return $buttons;
	}

	/**
	 * Add Next Page/Page Break Button
	 * in WordPress Visual Editor
	 *
	 * @link http://shellcreeper.com/?p=889
	 * @link http://shellcreeper.com/how-to-add-next-page-or-page-break-button-in-wordpress-editor/
	 *
	 * @see wp-includes\class-wp-editor.php
	 *
	 * @param  array  $buttons   Array with WP editor buttons registered.
	 * @param  string $editor_id Unique editor identifier, e.g. 'content'.
	 *
	 * @return array             Array with new buttons.
	 */
	public function break_page_button( $buttons, $editor_id ) {

		/**
		 * Only add this for content editor
		 */
		if ( 'content' !== $editor_id ) {
			return $buttons;
		}

		/**
		 * Add next page after more tag button
		 */
		array_splice( $buttons, 13, 0, 'wp_page' );

		return $buttons;
	}
}
