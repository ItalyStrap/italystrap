<?php
/**
 * Display the TinyMCE wp_editor in taxonomy description page
 * This is an idea from:
 * @link http://www.paulund.co.uk/add-tinymce-editor-category-description
 * @link http://www.creativedev.in/2013/12/category-description-with-html-editor-in-wordpress/
 * @link https://pippinsplugins.com/adding-custom-meta-fields-to-taxonomies/
 * 
 * I have improved the code found in those page because it wasn't much clean and powerfull, now it is (os I hope so) :-)
 */
class ItalyStrapAdminCategoryEditor{
	
	function __construct(){

		global $pagenow;

		if ( $pagenow === 'edit-tags.php' )
			$this->init();

	}

	/**
	 * Initialize class
	 * @return void Initialize class
	 */
	public function init(){

		add_action( 'admin_print_footer_scripts', array( $this, 'remove_default_taxonomy_description' ) );
		add_action( 'admin_print_styles', array( $this, 'add_inline_style' ) );

		/**
		 * Get the taxonomy array
		 * @var array
		 */
		$taxonomies = get_taxonomies();

		/**
		 * Unset some default value in which there isn't needed to display TinyMCE editor
		 */
		unset($taxonomies['nav_menu']);
		unset($taxonomies['link_category']);
		unset($taxonomies['post_format']);

		foreach( $taxonomies as $taxonomy ) {

			add_filter( $taxonomy . '_edit_form_fields', array( $this, 'taxonomy_description' ) );
			add_filter( $taxonomy . '_add_form_fields', array( $this, 'taxonomies_description' ) );

		}// end foreach

		/**
		 * Because the TinyMce editors allow freeform HTML we should remove these filters from the term description element.
		 */
		remove_filter( 'pre_term_description', 'wp_filter_kses' );
		remove_filter( 'term_description', 'wp_kses_data' );

	}

	/**
	 * Print the WordPress TinyMCE editor
	 * @param  object $tax Object of taxonomy informations
	 * @return string      Return the WP Editor
	 */
	public function print_wp_editor( $tax = '' ){

		$settings = array(
			'wpautop'			=> true,
			'media_buttons'		=> true,
			'quicktags'			=> true,
			'textarea_rows'		=> '15',
			'textarea_name'		=> 'description'
			);

		wp_editor( wp_kses_post( $tax->description , ENT_QUOTES, 'UTF-8' ), 'cat_description', $settings );

	}

	/**
	 * Display new filed in list page of taxonomy
	 * @param  object $tax Taxonomy object
	 * @return string      Return new field
	 */
	public function taxonomies_description( $tax ){
		?>

		<div class="form-field">
			<label for="description"><?php _ex('Description', 'Taxonomy Description'); ?></label>
			<?php $this->print_wp_editor( $tax ); ?>
			<br />
			<span class="description"><?php _e('The description is not prominent by default; however, some themes may show it.'); ?></span>
		</div>

		<?php
	}

	/**
	 * Display new filed in single taxonomy page
	 * @param  object $tax Taxonomy object
	 * @return string      Return new field
	 */
	public function taxonomy_description( $tax ){

		?>

		<table class="form-table">
			<tr class="form-field">
				<th scope="row" valign="top"><label for="description"><?php _ex('Description', 'Taxonomy Description'); ?></label></th>
				<td>
					<?php $this->print_wp_editor( $tax ); ?>
					<br />
					<span class="description"><?php _e('The description is not prominent by default; however, some themes may show it.'); ?></span>
				</td>
			</tr>
		</table>
		<?php
	}

	/**
	 * Add CSS inline for old fields
	 */
	public function add_inline_style() {
	?>
		<style type="text/css">
			.term-description-wrap{display: none;}
			.quicktags-toolbar input{float:left !important; width:auto !important;}
		</style>
	<?php 
	}

	/**
	 * Remove the default taxonomy description field
	 * @return string Add jQuery snipet for removing old description field
	 */
	public function remove_default_taxonomy_description(){

		?>
		<script type="text/javascript">
			jQuery(function($) {
				$('textarea#description').closest('tr.form-field').remove();
				$('.term-description-wrap').remove();
			});
		</script>
		<?php

	}


}
if ( is_admin() )
	new ItalyStrapAdminCategoryEditor;