<?php
/**
 * Header_Image Controller API
 *
 * This class renders the Header_Image output on the registered position.
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Components\Headers;

use \ItalyStrap\Config\ConfigInterface as Config;

/**
 * The Header_Image controller class
 */
class Image {

	private $data = [];
	private $config;

	/**
	 * Store the custom header settings
	 *
	 * @var null
	 */
	private $custom_header = null;

	/**
	 * The ID of the custom header image of the post_type
	 *
	 * @var int
	 */
	private $post_meta_id;

	private $size = array();

	function __construct( Config $config ) {
		$this->config = $config;
	}

	/**
	 * Init property
	 */
	private function _init_property() {

		/**
		 * ID of the custom header image for post_type
		 *
		 * @var int|null
		 */
		$this->post_meta_id = \absint( \get_post_meta( \get_the_ID(), '_italystrap_custom_header_id', true ) );

		/**
		 * Get the header object
		 *
		 * @var \stdClass
		 */
		$this->custom_header = \get_custom_header();
	}

	/**
	 * Get an HTML img element representing an image attachment for the theme header
	 *
	 * @param  int    $id   Image attachment ID.
	 * @param  string $size Image size. Accepts any valid image size,
	 *                      or an array of width and height values in
	 *                      pixels (in that order). Default value: 'full-width'
	 * @param  array  $attr Attributes for the image markup. Default value: ''
	 *
	 * @return string       HTML img element or empty string on failure.
	 */
	private function get_attachment_image( $id, $size = 'full', array $attr = [] ) {
	// full-width
		$attr = array(
			'class'		=> "center-block img-responsive img-fluid attachment-$id attachment-header size-header",
			'alt'		=> esc_attr( $this->config->get( 'GET_BLOGINFO_NAME' ) ),
			'itemprop'	=> 'image',
		);

		$attr = \apply_filters( 'italystrap_custom_header_image_attr', $attr );

		return \wp_get_attachment_image( $id, $size, false, $attr );
	}

	/**
	 * Get the custom header image
	 *
	 * @param \stdClass    $image_obj The custom image object.
	 *
	 * @return string      The image HTML.
	 */
	private function get_custom_header_image( \stdClass $image_obj, $size ) {

		if ( ! isset( $image_obj->attachment_id ) ) {
			return sprintf(
				'<img%s>',
				\ItalyStrap\HTML\get_attr( 'custom_header', [
					'src'		=> $image_obj->url,
					'width'		=> $image_obj->width,
					'height'	=> $image_obj->height,
					'alt'		=> $this->config->get( 'GET_BLOGINFO_NAME' ),
				] )
			);
		}

		$id = $image_obj->attachment_id;

		$output = $this->get_attachment_image( $id );

		return apply_filters( 'italystrap_custom_header_image', $output );
	}

	/**
	 * The Custom Header
	 */
	private function custom_header() {

		$this->size = array(
			'container'			=> 'full-width',
			'container-fluid'	=> 'full',
			// 'none'				=> 'full',
		);

		$size = $this->size[ $this->config->get('custom_header')['container_width'] ];

		if ( ! empty( $this->post_meta_id ) ) {
			return $this->get_attachment_image( $this->post_meta_id, $size );
		}

		return $this->get_custom_header_image( $this->custom_header, $size );
	}

	/**
	 * @TODO get_header_image_tag( $attr = array() )
	 */
	public function get_data() : array {

		$this->_init_property();

		$this->data['output'] = $this->custom_header();

		return $this->data;
	}
}
