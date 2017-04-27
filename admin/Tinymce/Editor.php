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

use ItalyStrap\Event\Subscriber_Interface;

/**
 * Improve WordPress text editor
 */
class Editor implements Subscriber_Interface {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked mce_buttons_2 - 10
	 * @hooked mce_buttons   - 1
	 * @hooked tiny_mce_before_init   - 9999
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		return array(
			// 'hook_name'							=> 'method_name',
			'mce_buttons_2'	=> 'reveal_hidden_tinymce_buttons',
			'mce_buttons'	=> array(
				'function_to_add'	=> 'break_page_button',
				'priority'			=> 1,
				'accepted_args'		=> 2,
			),
			'tiny_mce_before_init'	=> array(
				'function_to_add'	=> 'add_new_format_to_mce',
				'priority'			=> 9999,
				'accepted_args'		=> 2,
			),
		);
	}

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
	public function reveal_hidden_tinymce_buttons( array $buttons ) {

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
	public function break_page_button( array $buttons, $editor_id ) {

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

	/**
	 * Insert new mce format.
	 *
	 * @link http://wordpress.stackexchange.com/questions/128931/tinymce-adding-css-to-format-dropdown
	 * @link http://wordpress.stackexchange.com/questions/3882/can-i-add-a-custom-format-to-the-format-option-in-the-text-panel
	 *
	 * @see bootstrap/_type.scss for more HTML tags.
	 *
	 * @param  array  $mceInit   An array with TinyMCE config.
	 * @param  string $editor_id Unique editor identifier, e.g. 'content'.
	 *
	 * @return array             The new array.
	 */
	public function add_new_format_to_mce( array $mceInit, $editor_id ) {

		/**
		 * Only add this for content editor
		 */
		if ( 'content' !== $editor_id ) {
			return $mceInit;
		}

		// $defaultStyleFormats = array(
			// array(
			// 	'title'	=> __( 'Headers', 'italystrap' ),
			// 	'items'	=> array(
			// 		array(
			// 			'title'		=> __( 'Header 1', 'italystrap' ),
			// 			'format'	=> 'h1',
			// 		),
			// 		array(
			// 			'title'		=> __( 'Header 2', 'italystrap' ),
			// 			'format'	=> 'h2',
			// 		),
			// 		array(
			// 			'title'		=> __( 'Header 3', 'italystrap' ),
			// 			'format'	=> 'h3',
			// 		),
			// 		array(
			// 			'title'		=> __( 'Header 4', 'italystrap' ),
			// 			'format'	=> 'h4',
			// 		),
			// 		array(
			// 			'title'		=> __( 'Header 5', 'italystrap' ),
			// 			'format'	=> 'h5',
			// 		),
			// 		array(
			// 			'title'		=> __( 'Header 6', 'italystrap' ),
			// 			'format'	=> 'h6',
			// 		),
			// 	),
			// ),
			// array(
			// 	'title'	=> __( 'Inline' ),
			// 	'items'	=> array(
			// 		array(
			// 			'title'		=> 'Bold',
			// 			'icon'		=> 'bold',
			// 			'format'	=> 'bold',
			// 		),
			// 		array(
			// 			'title'		=> 'Italic',
			// 			'icon'		=> 'italic',
			// 			'format'	=> 'italic',
			// 		),
			// 		array(
			// 			'title'		=> 'Underline',
			// 			'icon'		=> 'underline',
			// 			'format'	=> 'underline',
			// 		),
			// 		array(
			// 			'title'		=> 'Strikethrough',
			// 			'icon'		=> 'strikethrough',
			// 			'format'	=> 'strikethrough',
			// 		),
			// 		array(
			// 			'title'		=> 'Superscript',
			// 			'icon'		=> 'superscript',
			// 			'format'	=> 'superscript',
			// 		),
			// 		array(
			// 			'title'		=> 'Subscript',
			// 			'icon'		=> 'subscript',
			// 			'format'	=> 'subscript',
			// 		),
			// 		array(
			// 			'title'		=> 'Code',
			// 			'icon'		=> 'code',
			// 			'format'	=> 'code',
			// 		),
			// 		array(
			// 			'title'		=> 'Small',
			// 			// 'icon'		=> 'small',
			// 			'format'	=> 'small',
			// 			'wrapper'	=> true,
			// 		),
			// 	),
			// ),
			// array(
			// 	'title'	=> __( 'Blocks' ),
			// 	'items'	=> array(
			// 		array(
			// 			'title'		=> 'Paragraph',
			// 			'format'	=> 'p',
			// 		),
			// 		array(
			// 			'title'		=> 'Blockquote',
			// 			'format'	=> 'blockquote',
			// 		),
			// 		array(
			// 			'title'		=> 'Div',
			// 			'format'	=> 'div',
			// 		),
			// 		array(
			// 			'title'		=> 'Pre',
			// 			'format'	=> 'pre',
			// 		),
			// 	),
			// ),
			// array(
			// 	'title'	=> __( 'Alignment' ),
			// 	'items'	=> array(
			// 		array(
			// 			'title'		=> 'Left',
			// 			'icon'		=> 'alignleft',
			// 			'format'	=> 'alignleft',
			// 		),
			// 		array(
			// 			'title'		=> 'Center',
			// 			'icon'		=> 'aligncenter',
			// 			'format'	=> 'aligncenter',
			// 		),
			// 		array(
			// 			'title'		=> 'Right',
			// 			'icon'		=> 'alignright',
			// 			'format'	=> 'alignright',
			// 		),
			// 		array(
			// 			'title'		=> 'Justify',
			// 			'icon'		=> 'alignjustify',
			// 			'format'	=> 'alignjustify',
			// 		),
			// 	),
			// ),
		// );

		$mceInit['style_formats_merge'] = true;

		$defaultStyleFormats = array(
			array(
				'title' => 'Small',
				'block' => 'small',
				// 'classes' => 'small',
				'wrapper' => true,
			),
		);

		$mceInit['style_formats'] = json_encode( $defaultStyleFormats );

		return $mceInit;
	}
}
