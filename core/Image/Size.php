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
	}
}
