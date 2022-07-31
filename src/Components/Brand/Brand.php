<?php
declare(strict_types=1);

namespace ItalyStrap\Components\Brand;

use ItalyStrap\Config\ConfigInterface;

/**
 * Class Logo
 * @package ItalyStrap\Components\Brand
 *
 * ID
 * $this->config->get( 'navbar_logo_image' )
 *
 * @deprecated
 */
class Brand {

	const MODS_LOGO_KEY = 'custom_logo';

	/**
	 * @var ConfigInterface
	 */
	private $config;
	/**
	 * @var CustomLogo
	 */
	private $custom_logo;


	/**
	 * Logo constructor.
	 * @param ConfigInterface $config
	 * @param CustomLogo $custom_logo
	 */
	public function __construct( ConfigInterface $config, CustomLogo $custom_logo ) {
		$this->config = $config;
		$this->custom_logo = $custom_logo;
	}

	public function render(): string {
		return $this->custom_logo->render();
	}

	/**
	 * Get Brand
	 *
	 * @return string Return the HTML for brand name and/or image.
	 */
	private function brand() {

		/**
		 * @see \get_custom_logo()
		 * @see \the_custom_logo()
		 */

		/**
		 * The ID of the logo image for navbar
		 * By default in the customizer is set a url for the image instead of an integer
		 * When it is choices an image than it will set an integer for $this->config['navbar_logo']
		 *
		 * @var integer
		 */
		$attachment_id = (int)apply_filters(
			'italystrap_navbar_logo_image_id',
			$this->config->get( 'navbar_logo_image' )
		);

		$brand = '';

		if ( $attachment_id && 'display_image' === $this->config[ 'display_navbar_brand' ] ) {
			$attr = array(
				'class' => 'img-brand img-responsive center-block',
				'alt' =>
					esc_attr( \get_option( 'blogname' ) )
					. ' &dash; '
					. esc_attr( \get_option( 'blogdescription' ) ),
				'itemprop' => 'image',
			);

			/**
			 * Size default: navbar-brand-image
			 */
			$brand .= wp_get_attachment_image(
				$attachment_id,
				$this->config[ 'navbar_logo_image_size' ],
				false,
				$attr
			);

			$brand .= '<meta  itemprop="name" content="'
				. esc_attr( \get_option( 'blogname' ) ) . '"/>';
		} elseif ( $attachment_id && 'display_all' === $this->config[ 'display_navbar_brand' ] ) {
			$attr = array(
				'class' => 'img-brand img-responsive center-block',
				'alt' => esc_attr( \get_option( 'blogname' ) )
					. ' - '
					. esc_attr( \get_option( 'blogdescription' ) ),
				'itemprop' => 'image',
				'style' => 'display:inline;margin-right:15px;',
			);

			/**
			 * Size default: navbar-brand-image
			 */
			$brand .= wp_get_attachment_image(
				$attachment_id,
				$this->config[ 'navbar_logo_image_size' ],
				false,
				$attr
			);

			$brand .= '<span class="brand-name" itemprop="name">'
				. esc_attr( \get_option( 'blogname' ) ) . '</span>';
		} else {
			$brand .= '<span class="brand-name" itemprop="name">'
				. esc_attr( \get_option( 'blogname' ) )
				. '</span>';
		}

		return $brand;
	}
}
