<?php
/**
 * Initialize custom meta box build with CMB2
 *
 * @package ItalyStrap\Admin
 * @version 1.0
 * @since   4.0.0
 */

namespace ItalyStrap\Admin;

/**
 * Add some custom meta box in many areas of WordPress
 */
class Custom_Meta_Box {

	/**
	 * CMB prefix
	 *
	 * @var string
	 */
	private $prefix;

	/**
	 * CMB _prefix
	 *
	 * @var string
	 */
	private $_prefix;

	/**
	 * Init the constructor
	 */
	function __construct() {

		/**
		 * Start with an underscore to hide fields from custom fields list
		 *
		 * @var string
		 */
		$this->prefix = 'italystrap';

		$this->_prefix = '_' . $this->prefix;

	}

	/**
	 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
	 */
	public function register_template_settings() {

		$template_settings_metabox_object_types = apply_filters( 'italystrap_template_settings_metabox_object_types', array( 'page', 'post' ) );

		/**
		 * Sample metabox to demonstrate each field type included
		 */
		$cmb = new_cmb2_box(
			array(
				'id'            => $this->prefix . '-template-settings-metabox',
				'title'         => __( 'Advanced settings', 'ItalyStrap' ),
				'object_types'  => $template_settings_metabox_object_types,
				'context'    => 'side',
				'priority'   => 'low',
			)
		);

		$template_settings_metabox_options = apply_filters( 'italystrap_template_settings_metabox_options',
			array(
				'hide_breadcrumbs'	=> __( 'Hide breadcrumbs', 'ItalyStrap' ),
				'hide_title'		=> __( 'Hide title', 'ItalyStrap' ),
				'hide_meta'			=> __( 'Hide meta info', 'ItalyStrap' ),
				'hide_thumb'		=> __( 'Hide feautured image', 'ItalyStrap' ),
				'hide_figcaption'	=> __( 'Hide figure caption', 'ItalyStrap' ),
				'hide_content'		=> __( 'Hide the content', 'ItalyStrap' ),
				'hide_author'		=> __( 'Hide author box', 'ItalyStrap' ),
				'hide_social'		=> __( 'Hide builtin social sharing', 'ItalyStrap' ),
				'hide_comments'		=> __( 'Hide comments', 'ItalyStrap' ),
				'hide_comments_form'=> __( 'Hide comments form', 'ItalyStrap' ),
				// 'hide_sidebar'		=> __( 'Hide sidebar', 'ItalyStrap' ),
			)
		);

		$cmb->add_field(
			array(
				'name'		=> __( 'Template settings', 'ItalyStrap' ),
				'desc'		=> __( 'Advance template setting for this page/post', 'ItalyStrap' ),
				'id'		=> $this->_prefix . '_template_settings',
				'type'		=> 'multicheck',
				'options'	=> $template_settings_metabox_options,
			)
		);
	}
}
