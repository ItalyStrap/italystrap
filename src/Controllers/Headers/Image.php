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

namespace ItalyStrap\Controllers\Headers;

use ItalyStrap\Controllers\Controller;
use ItalyStrap\Event\Subscriber_Interface;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

/**
 * The Header_Image controller class
 */
class Image extends Controller implements Subscriber_Interface  {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked 'italystrap_content_header' - 10
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		return array(
			// 'hook_name'							=> 'method_name',
			'italystrap_content_header'	=> 'render',
		);
	}

	/**
	 * File name for the view
	 *
	 * @var string
	 */
	protected $file_name = 'headers/image';

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

	/**
	 * Init property
	 *
	 * @param  string $value [description]
	 * @return string        [description]
	 */
	private function _init_property() {

		/**
		 * ID of the custom header image for post_type
		 *
		 * @var int|null
		 */
		$this->post_meta_id = absint( get_post_meta( $this->get_the_ID(), '_italystrap_custom_header_id', true ) );

		/**
		 * Get the header object
		 *
		 * @var object
		 */
		$this->custom_header = get_custom_header();
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
	private function get_attachment_image( $id, $size = 'full', array $attr = array() ) {
	// full-width
		$attr = array(
			'class'		=> "center-block img-responsive img-fluid attachment-$id attachment-header size-header",
			'alt'		=> esc_attr( GET_BLOGINFO_NAME ),
			'itemprop'	=> 'image',
		);

		$attr = apply_filters( 'italystrap_custom_header_image_attr', $attr );

		return wp_get_attachment_image( $id , $size, false, $attr );
	
	}

	/**
	 * Get the custom header image
	 *
	 * @param  obj    $image_obj The custom image object.
	 *
	 * @return string            The image HTML.
	 */
	private function get_custom_header_image( $image_obj, $size ) {

		if ( ! isset( $image_obj->attachment_id ) ) {
			return sprintf(
				'<img%s>',
				\ItalyStrap\HTML\get_attr( 'custom_header', [
					'src'		=> $image_obj->url,
					'width'		=> $image_obj->width,
					'height'	=> $image_obj->height,
					'alt'		=> GET_BLOGINFO_NAME,
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

		$size = $this->size[ $this->theme_mod['custom_header']['container_width'] ];

		if ( ! empty( $this->post_meta_id ) ) {
			return $this->get_attachment_image( $this->post_meta_id, $size );
		}

		return $this->get_custom_header_image( $this->custom_header, $size );
	}

	/**
	 * Render the output of the controller.
	 */
	public function render() {

		if ( ! has_header_image() ) {
			return;
		}

		$this->_init_property();

		$this->data['custom_header'] = $this->custom_header();
		$this->data['theme_mod'] = $this->theme_mod;

		parent::render();
	}
}
