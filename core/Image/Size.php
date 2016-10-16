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
	 * Default image size definitions
	 *
	 * @var array
	 */
	private $default_image = array();

	/**
	 * Init the class
	 *
	 * @param [type] $argument [description].
	 */
	function __construct( array $theme_mods = array() ) {
		$this->theme_mods = $theme_mods;

		$this->default_image = array(
			'navbar-brand-image'	=> array(
				'width'		=> 45,
				'height'	=> 45,
				'crop'		=> true,
			),
			'full-width'			=> array(
				'width'		=> 1140,
				'height'	=> 9999,
				'crop'		=> false,
			),
		);
	}

	/**
	 * Register image size
	 */
	public function register() {
	
		foreach ( $this->default_image as $name => $params ) {
			add_image_size(
				$name,
				$params['width'],
				$params['height'],
				$params['crop']
			);
		}
	
	}
}
