<?php
/**
 * Class Image size API
 *
 * This class handle the image size in WordPress
 *
 * @link [URL]
 * @since 4.0.0
 *
 * @package Italystrap
 */

namespace ItalyStrap\Core\Image;

/**
 * Class definition
 */
class Size {

	/**
	 * Image size
	 *
	 * @var array
	 */
	private $image_sizes = array();

	/**
	 * Init the class
	 *
	 * @param [type] $argument [description].
	 */
	function __construct( array $theme_mods = array() ) {
		$this->theme_mods = $theme_mods;

		$this->image_sizes = $this->theme_mods['image_size'];
	}

	/**
	 * Generate image size from breakpoint
	 */
	public function get_image_size_from_breakpoint() {

		if ( empty( $this->theme_mods['breakpoint'] ) ) {
			return array();
		}

		foreach ( $this->theme_mods['breakpoint'] as $key => $width ) {
			$this->image_sizes[ $key ]['width'] = (int) $width;
			$this->image_sizes[ $key ]['height'] = 9999;
			$this->image_sizes[ $key ]['crop'] = true;
		}
	
	}

	/**
	 * Add image sizes
	 *
	 * @param  array $image_sizes [description]
	 * @return string        [description]
	 */
	private function add_image_sizes( array $image_sizes ) {

		foreach ( $image_sizes as $name => $params ) {

			if ( ! is_array( $params ) ) {
				continue;
			}

			if ( ! isset( $params['width'] ) || ! isset( $params['height'] ) ) {
				continue;
			}

			$width  = (int) $params['width'];
			$height = (int) $params['height'];
			$crop   = isset( $params['crop'] ) ? $params['crop'] : false;

			add_image_size(
				$name,
				$params['width'],
				$params['height'],
				$params['crop']
			);
		}
	}

	/**
	 * Register image size
	 */
	public function register() {

		$this->get_image_size_from_breakpoint();

		$this->add_image_sizes( $this->image_sizes );

		$height = round( $this->theme_mods['content_width'] * 3 / 4 );

		/**
		 * 'post-thumbnails' is by default the size displayed for posts, pages and all archives.
		 */
		set_post_thumbnail_size( $this->theme_mods['content_width'], $height );

		/**
		 * thumbnail_size_w
		 * thumbnail_size_h
		 * thumbnail_crop
		 * medium_size_h: The medium size height.
		 * medium_size_w: The medium size width.
		 * large_size_h: The large size height.
		 * large_size_w: The large size width.
		 *
		 * @example update_option( 'large_size_h', 700 );
		 * @link https://developer.wordpress.org/reference/functions/add_image_size/
		 *
		 * @example add_image_size('medium', get_option( 'medium_size_w' ), get_option( 'medium_size_h' ), true ); // For cropping the default image size.
		 * Maybe first remove_image_size and then add_image_size it's better
		 * @link http://wordpress.stackexchange.com/questions/30965/set-default-image-sizes-in-wordpress-to-hard-crop
		 */
	}
}
