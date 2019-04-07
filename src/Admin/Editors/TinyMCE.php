<?php
/**
 * Initialize custom meta box build with CMB2
 *
 * @link https://codex.wordpress.org/TinyMCE_Custom_Styles
 * @link https://codex.wordpress.org/TinyMCE_Custom_Buttons
 *
 * @package ItalyStrap\Admin
 *
 * @version 1.0
 * @since   4.0.0
 */

namespace ItalyStrap\Admin\Editors;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

use ItalyStrap\Event\Subscriber_Interface;

/**
 * Improve WordPress text editor
 */
class TinyMCE implements Subscriber_Interface {

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
		/* Register TinyMCE External Plugins */
		// add_filter( 'mce_external_plugins', array( $this, 'register_mce_external_plugins' ) );
		/* Add CSS to TinyMCE Editor */
		// add_filter( 'mce_css', array( $this, 'editor_css' ) );
		return [
			// 'hook_name'							=> 'method_name',
			'mce_external_plugins'	=> 'register_mce_external_plugins',
			'mce_css'				=> 'editor_css',
			'mce_buttons_2'			=> 'reveal_hidden_tinymce_buttons',
			'mce_buttons'			=> [
				'function_to_add'		=> 'break_page_button',
				'priority'				=> 1,
				'accepted_args'			=> 2,
			],
			'mce_buttons_4'			=> [
				'function_to_add'		=> 'mce_add_buttons_4_columns',
				'priority'				=> 10,
				'accepted_args'			=> 2,
			],
			'tiny_mce_before_init'	=> [
				'function_to_add'		=> 'add_new_format_to_mce',
				'priority'				=> 999,
				'accepted_args'			=> 2,
			],
		];
	}

	private $assets_mce_plugin_url = '';

	/**
	 * Contructor
	 */
	public function __construct() {
		$this->assets_mce_plugin_url = TEMPLATEURL . '/src/Admin/Editors/mce-plugins';
	}

	/**
	 * Register MCE External Plugins
	 * @since 0.1.0
	 */
	public function register_mce_external_plugins( array $plugins ){

		/* Columns */
		// if( true ){
			$plugins['wpe_addon_columns'] = $this->assets_mce_plugin_url . '/columns/editor.js';
		// }

		return $plugins;
	}

	/**
	 * MCE/Editor CSS
	 * @since 0.1.0
	 */
	public function editor_css( $mce_css ){

		/* Only if buttons, boxes, or columns active */
		// if( fx_editor_is_custom_feature_active() && apply_filters( 'fx_editor_load_editor_css', true ) ){
			$mce_css .= \sprintf(
				',%s',
				$this->assets_mce_plugin_url . '/columns/editor.css'
			);
		// }

		return $mce_css;
	}

	/**
	 * Add button to 4th row in editor: Columns
	 * @since 0.1.0
	 */
	public function mce_add_buttons_4_columns( array $buttons, $editor_id ){

		/* Make editor id filterable. Set to false to enable anywhere. */
		// $columns_editor_ids = apply_filters( 'fx_editor_columns_editor_ids', false );
		// if( is_array( $columns_editor_ids ) && ! in_array( $editor_id, $columns_editor_ids ) ){
		// 	return $buttons;
		// }

		/* Columns */
		// if( fx_editor_get_option( 'columns', false ) ){
			\array_push( $buttons,
				'wpe_addon_col_12_12',
				'wpe_addon_col_13_23',
				'wpe_addon_col_23_13',
				'wpe_addon_col_13_13_13',
				'wpe_addon_col_14_14_14'
			);
		// }

		return $buttons;
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
		\array_unshift( $buttons, 'styleselect' );

		return $buttons;
	}

	/**
	 * Add Next Page/Page Break Button
	 * in WordPress Visual Editor
	 *
	 * @link http://shellcreeper.com/?p=889
	 * @link http://shellcreeper.com/how-to-add-next-page-or-page-break-button-in-wordpress-editor/
	 *
	 * @link https://www.tinymce.com/docs-3x//reference/buttons/
	 *
	 * @see wp-includes\class-wp-editor.php
	 *
	 * @param  array  $buttons   Array with WP editor buttons registered.
	 * @param  string $editor_id Unique editor identifier, e.g. 'content'.
	 *
	 * @return array             Array with new buttons.
	 */
	public function break_page_button( array $buttons, $editor_id ) {

		// $buttons[] = 'fontselect';

		/**
		 * Only add this for content editor
		 */
		// if ( 'content' !== $editor_id ) {
		// 	return $buttons;
		// }

		/**
		 * Add next page after more tag button
		 */
		\array_splice( $buttons, 13, 0, 'wp_page' );

		return $buttons;
	}

	/**
	 * Insert new mce format.
	 *
	 * @link https://codex.wordpress.org/Plugin_API/Filter_Reference/tiny_mce_before_init
	 * @link https://codex.wordpress.org/TinyMCE_Custom_Styles
	 *
	 * @link http://wordpress.stackexchange.com/questions/128931/tinymce-adding-css-to-format-dropdown
	 * @link http://wordpress.stackexchange.com/questions/3882/can-i-add-a-custom-format-to-the-format-option-in-the-text-panel
	 *
	 * @link http://www.wpexplorer.com/wordpress-tinymce-tweaks/
	 *
	 * @see bootstrap/_type.scss for more HTML tags.
	 *
	 * @param  array  $config    An array with TinyMCE config.
	 * @param  string $editor_id Unique editor identifier, e.g. 'content'.
	 *
	 * @return array             The new array.
	 */
	public function add_new_format_to_mce( array $config, $editor_id ) {

		$config['style_formats_merge'] = true;

		$default = require __DIR__ . '/config/style_formats.php';

		$default = \apply_filters( 'italystrap_style_formats_config', $default );

		// d( $config );
		// d( $config['formats'] );
		// d( $config['style_formats'] );

		$config['style_formats'] = \wp_json_encode( $default );

		// d( $config['style_formats'] );

		return $config;
	}
}
