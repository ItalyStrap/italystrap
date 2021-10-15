<?php
declare(strict_types=1);

namespace ItalyStrap\Components\Headers;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\HTML\Attributes;

/**
 * The Header_Image controller class
 * @deprecated
 */
class CustomHeader {

	public const OUTPUT = 'output';

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

	private $size = [];

	/**
	 * @var Attributes
	 */
	private $attributes;

	public function __construct( ConfigInterface $config, Attributes $attributes ) {
		$this->config = $config;
		$this->attributes = $attributes;
	}

	/**
	 * Init property
	 */
	private function initProperty() {

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
	private function getAttachmentImage( $id, $size = 'full', array $attr = [] ) {
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
	private function getCustomHeaderImage( \stdClass $image_obj, $size ) {

		if ( ! isset( $image_obj->attachment_id ) ) {
			return sprintf(
				'<img%s>',
				$this->attributes->render( 'custom_header', [
					'src'		=> \esc_url( $image_obj->url ),
					'width'		=> \esc_attr( $image_obj->width ),
					'height'	=> \esc_attr( $image_obj->height ),
					'alt'		=> \esc_html( $this->config->get( 'GET_BLOGINFO_NAME' ) ),
				] )
			);
		}

		$id = $image_obj->attachment_id;

		$output = $this->getAttachmentImage( $id );

		return apply_filters( 'italystrap_custom_header_image', $output );
	}

	/**
	 * The Custom Header
	 */
	private function customHeader() {

		$this->size = array(
			'container'			=> 'full-width',
			'container-fluid'	=> 'full',
			// 'none'				=> 'full',
		);

		$size = $this->size[ $this->config->get('custom_header')['container_width'] ];

		if ( ! empty( $this->post_meta_id ) ) {
			return $this->getAttachmentImage( $this->post_meta_id, $size );
		}

		/**
		 * @see the_custom_header_markup()
		 */
		return $this->getCustomHeaderImage( $this->custom_header, $size );
	}

	/**
	 * @TODO get_header_image_tag( $attr = array() )
	 */
	public function getData() : array {

		$this->initProperty();

		$this->data[ static::OUTPUT ] = $this->customHeader();
//		$this->data[ self::class ] = $this;

		return $this->data;
	}
}
