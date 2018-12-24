<?php
/**
 * Handle the category editor
 *
 * [Long Description.]
 *
 * @link [URL]
 * @since 4.0.0
 *
 * @package ItalyStrap\Admin
 */

namespace ItalyStrap\Editors;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

use ItalyStrap\Event\Subscriber_Interface;
/**
 * Display the TinyMCE wp_editor in taxonomy description page
 * This is an idea from:
 *
 * @link http://www.paulund.co.uk/add-tinymce-editor-category-description
 * @link http://www.creativedev.in/2013/12/category-description-with-html-editor-in-wordpress/
 * @link https://pippinsplugins.com/adding-custom-meta-fields-to-taxonomies/
 *
 * I have improved the code found in those page because it wasn't much clean and powerfull, now it is (os I hope so) :-)
 */
class Category implements Subscriber_Interface {

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
			'italystrap_plugin_app_loaded'	=> 'init',
		);
	}

	/**
	 * Init the constructor
	 */
	// function __construct() {

	// 	global $pagenow;

	// 	if ( 'edit-tags.php' === $pagenow || 'term.php' === $pagenow ) {
	// 		$this->init();
	// 	}
	// }

	/**
	 * Initialize class
	 */
	public function init() {

		add_action( 'admin_print_footer_scripts', array( $this, 'remove_default_taxonomy_description' ) );
		add_action( 'admin_print_styles', array( $this, 'add_inline_style' ) );

		/**
		 * Get the taxonomy array
		 *
		 * @var array
		 */
		$taxonomies = get_taxonomies();

		/**
		 * Unset some default value in which there
		 * isn't needed to display TinyMCE editor
		 */
		unset( $taxonomies['nav_menu'] );
		unset( $taxonomies['link_category'] );
		unset( $taxonomies['post_format'] );

		foreach ( $taxonomies as $taxonomy ) {

			add_filter( $taxonomy . '_edit_form_fields', array( $this, 'taxonomy_description' ) );
			add_filter( $taxonomy . '_add_form_fields', array( $this, 'taxonomies_description' ) );

		}

		/**
		 * Because the TinyMce editors allow freeform HTML we should
		 * remove these filters from the term description element.
		 */
		remove_filter( 'pre_term_description', 'wp_filter_kses' );
		remove_filter( 'term_description', 'wp_kses_data' );
	}

	/**
	 * Print the WordPress TinyMCE editor
	 *
	 * @param  object $tax Object of taxonomy informations.
	 */
	public function print_wp_editor( $tax = '' ) {

		$settings = array(
			'wpautop'			=> true,
			'media_buttons'		=> true,
			'quicktags'			=> true,
			'textarea_rows'		=> '15',
			'textarea_name'		=> 'description',
			);

		$description = ( isset( $tax->description ) ) ? $tax->description : '';

		wp_editor( wp_kses_post( $description , ENT_QUOTES, 'UTF-8' ), 'cat_description', $settings );
	}

	/**
	 * Display new filed in list page of taxonomy
	 *
	 * @param  object $tax Taxonomy object.
	 */
	public function taxonomies_description( $tax ) {

		?><div class="form-field">
			<label for="description"><?php echo esc_html_x( 'Description', 'Taxonomy Description', 'italystrap' ); ?></label>
			<?php $this->print_wp_editor( $tax ); ?>
			<br />
			<span class="description"><?php esc_html_e( 'The description is not prominent by default; however, some themes may show it.', 'italystrap' ); ?></span>
		</div><?php
	}

	/**
	 * Display new filed in single taxonomy page
	 *
	 * @param  object $tax Taxonomy object.
	 */
	public function taxonomy_description( $tax ) {

		?><table class="form-table">
			<tr class="form-field">
				<th scope="row" valign="top"><label for="description"><?php echo esc_html_x( 'Description', 'Taxonomy Description', 'italystrap' ); ?></label></th>
				<td>
					<?php $this->print_wp_editor( $tax ); ?>
					<br />
					<span class="description"><?php esc_html_e( 'The description is not prominent by default; however, some themes may show it.', 'italystrap' ); ?></span>
				</td>
			</tr>
		</table><?php
	}

	/**
	 * Add CSS inline for old fields
	 */
	public function add_inline_style() {

	?><style type="text/css">.term-description-wrap{display: none;}.quicktags-toolbar input{float:left !important; width:auto !important;}</style><?php
	}

	/**
	 * Remove the default taxonomy description field
	 * Add jQuery snipet for removing old description field.
	 */
	public function remove_default_taxonomy_description() {

		?><script type="text/javascript">
			jQuery(function($) {
				$('textarea#description').closest('tr.form-field').remove();
				$('.term-description-wrap').remove();
			});
		</script><?php
	}
}
