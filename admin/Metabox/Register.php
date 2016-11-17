<?php
/**
 * Initialize custom meta box build with CMB2
 *
 * @package ItalyStrap\Admin
 * @version 1.0
 * @since   4.0.0
 */

namespace ItalyStrap\Admin\Metabox;

/**
 * Add some custom meta box in many areas of WordPress
 */
class Register {

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
				'title'         => __( 'Advanced settings', 'italystrap' ),
				'object_types'  => $template_settings_metabox_object_types,
				'context'    => 'side',
				'priority'   => 'low',
			)
		);

		$template_settings_metabox_options = apply_filters( 'italystrap_template_settings_metabox_options',
			array(
				'hide_breadcrumbs'	=> __( 'Hide breadcrumbs', 'italystrap' ),
				'hide_title'		=> __( 'Hide title', 'italystrap' ),
				'hide_meta'			=> __( 'Hide meta info', 'italystrap' ),
				'hide_thumb'		=> __( 'Hide feautured image', 'italystrap' ),
				'hide_figcaption'	=> __( 'Hide figure caption', 'italystrap' ),
				'hide_content'		=> __( 'Hide the content', 'italystrap' ),
				'hide_author'		=> __( 'Hide author box', 'italystrap' ),
				'hide_social'		=> __( 'Hide builtin social sharing', 'italystrap' ),
				'hide_comments'		=> __( 'Hide comments', 'italystrap' ),
				'hide_comments_form'=> __( 'Hide comments form', 'italystrap' ),
				// 'hide_sidebar'		=> __( 'Hide sidebar', 'italystrap' ),
			)
		);

		$cmb->add_field(
			array(
				'name'		=> __( 'Template settings', 'italystrap' ),
				'desc'		=> __( 'Advance template setting for this page/post', 'italystrap' ),
				'id'		=> $this->_prefix . '_template_settings',
				'type'		=> 'multicheck',
				'options'	=> $template_settings_metabox_options,
			)
		);

		/**
		 *
		 * @example https://github.com/WebDevStudios/CMB2/wiki/Field-Types#oembed
		 * $url = esc_url( get_post_meta( get_the_ID(), 'wiki_test_embed', 1 ) );
		 * echo wp_oembed_get( $url );
		 */
		// $cmb->add_field(
		// 	array(
		// 		'name'		=> __( 'Video URL', 'italystrap' ),
		// 		'desc'		=> sprintf(
		// 			'Enter a youtube, twitter, or instagram URL. Supports services listed at %s. This will be shown instead of feature image.',
		// 			'<a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>'
		// 			),
		// 		'default'	=> '',
		// 		'id'		=> $this->_prefix . '_oEmbed_url',
		// 		'type'		=> 'oembed',
		// 	) 
		// );
	}

	/**
	 * Register layout settings
	 */
	public function register_layout_settings() {
	
		$layout_settings_metabox_object_types = apply_filters( 'italystrap_layout_settings_metabox_object_types', array( 'page', 'post' ) );

		/**
		 * Sample metabox to demonstrate each field type included
		 */
		$cmb = new_cmb2_box(
			array(
				'id'            => $this->prefix . '-layout-settings-metabox',
				'title'         => __( 'Advanced settings', 'italystrap' ),
				'object_types'  => $layout_settings_metabox_object_types,
				'context'    => 'side',
				'priority'   => 'low',
			)
		);

		$layout_settings_metabox_options = apply_filters( 'italystrap_layout_settings_metabox_options',
			array(
				'full_width'				=> __( 'Full width, no sidebar', 'italystrap' ),
				'content_sidebar'			=> __( 'Content Sidebar', 'italystrap' ),
				'content_sidebar_sidebar'	=> __( 'Content Sidebar Sidebar', 'italystrap' ),
				'sidebar_content_sidebar'	=> __( 'Sidebar Content Sidebar', 'italystrap' ),
				'sidebar_sidebar_content'	=> __( 'Sidebar Sidebar content', 'italystrap' ),
				'sidebar_content'			=> __( 'Sidebar Content', 'italystrap' ),
			)
		);

		$post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : null;

		$cmb->add_field(
			array(
				'name'		=> __( 'Layout settings', 'italystrap' ),
				'desc'		=> __( 'Advance layout setting for this page/post', 'italystrap' ),
				'id'		=> $this->_prefix . '_layout_settings',
				'type'		=> 'radio',
				'options'	=> $layout_settings_metabox_options,
				'default'	=> PAGE_ON_FRONT === $post_id ? 'full_width' : 'content_sidebar',
			)
		);
	
	}
}
