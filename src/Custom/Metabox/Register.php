<?php
/**
 * Initialize custom meta box build with CMB2
 *
 * https://make.wordpress.org/core/2018/11/07/meta-box-compatibility-flags/
 *
 * @package ItalyStrap\Custom\Metabox
 * @version 1.0
 * @since   4.0.0
 */

namespace ItalyStrap\Custom\Metabox;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

use ItalyStrap\Config\Config_Interface as Config;
use ItalyStrap\Event\Subscriber_Interface;

/**
 * Add some custom meta box in many areas of WordPress
 */
class Register implements Subscriber_Interface {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked cmb2_admin_init - 10
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		return [
			// 'hook_name'							=> 'method_name',
			'cmb2_admin_init'	=> [
				'function_to_add'	=> 'register_metaboxes',
			],
		];
	}

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

	private $object_types = array();

	/**
	 * Init the constructor
	 */
	function __construct( Config $config ) {

		$this->config = $config;

		/**
		 * Start with an underscore to hide fields from custom fields list
		 *
		 * @var string
		 */
		$this->prefix = $config->get( 'prefix' );

		$this->_prefix = $config->get( '_prefix' );

//		$this->object_types = $config->get( 'theme_support' )['supported_post_type'];
		$this->supported_types = \apply_filters( 'italystrap_post_types_layout_support', [
			'supported_post_type'	=> [
				'page',
				'post',
				'download',
				'product',
				'forum',
				'topic',
				'reply',
			]
		] );

		$this->object_types = $this->supported_types['supported_post_type'];
	}

	/**
	 * Hook in and add a demo metabox.
	 * Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
	 */
	public function register_metaboxes() {

		$post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : null;
		$post_type = isset( $_GET['post_type'] ) ? esc_attr( $_GET['post_type'] ) : get_post_type( $post_id );

		/**
		 * Metabox for the showing of the template parts
		 */
		$cmb = new_cmb2_box(
			[
				'id'            => $this->prefix . '-template-settings-metabox',
				'title'         => __( 'Custom settings', 'italystrap' ),
				'object_types'  => $this->object_types,
				'context'    => 'side',
				'priority'   => 'low',
			]
		);

		$cmb->add_field(
			array(
				'name'				=> __( 'Page container witdh settings', 'italystrap' ),
				'desc'				=> sprintf(
					__( 'Choose the width of the page container for this %s', 'italystrap' ),
					$post_type
				),
				'id'				=> $this->_prefix . '_width_settings',
				'type'				=> 'radio',
				'show_option_none'	=> sprintf(
					__( 'Default width set in %s', 'italystrap' ),
					''
				),
				'options'			=> apply_filters( 'italystrap_theme_width', array() ),
			)
		);

		$cmb->add_field(
			array(
				'name'				=> __( 'Layout settings', 'italystrap' ),
				'desc'				=> sprintf(
					__( 'Advance layout setting for this %s', 'italystrap' ),
					$post_type
				),
				'id'				=> $this->_prefix . '_layout_settings',
				'type'				=> 'radio',
				'show_option_none'	=> sprintf(
					__( 'Default layout set in %s', 'italystrap' ),
					'link'
				),
				'options'			=> require PARENTPATH . '/config/layout.php',
			)
		);

		$cmb->add_field(
			array(
				'name'		=> __( 'Template settings', 'italystrap' ),
				'desc'		=> sprintf(
					__( 'Advance template content setting for this %s', 'italystrap' ),
					$post_type
				),
				'id'		=> $this->_prefix . '_template_settings',
				'type'		=> 'multicheck',
				'options'	=> require PARENTPATH . '/config/template-content.php',
			)
		);

		if ( current_theme_supports( 'custom-header' ) ) {
			$cmb->add_field(
				array(
					'name'			=> __( 'Custom header', 'italystrap' ),
					'desc'			=> __( 'The image for the theme header', 'italystrap' ),
					'id'			=> $this->_prefix . '_custom_header',
					'type'			=> 'file',
					'options'		=> array(
						'url'	=> false, // Hide the text input for the url
					),
					'default'		=> null,
					'text'			=> array(
						'add_upload_file_text' => __( 'Add or upload image', 'italystrap' )
					),
				)
			);
		}

		/**
		 * This functionality is not already developed
		 */
		if ( current_theme_supports( 'featured-video' ) ) {
			/**
			 *
			 * @example https://github.com/WebDevStudios/CMB2/wiki/Field-Types#oembed
			 * $url = esc_url( get_post_meta( get_the_ID(), 'wiki_test_embed', 1 ) );
			 * echo wp_oembed_get( $url );
			 */
			$cmb->add_field(
				array(
					'name'		=> __( 'Video URL', 'italystrap' ),
					'desc'		=> sprintf(
						'Enter a youtube, twitter, or instagram URL. Supports services listed at %s. This will be shown instead of feature image.',
						'<a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>'
						),
					'default'	=> '',
					'id'		=> $this->_prefix . '_featured_video',
					'type'		=> 'text',
				) 
			);
		}
	}
}
