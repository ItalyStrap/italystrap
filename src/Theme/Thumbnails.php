<?php
declare(strict_types=1);

namespace ItalyStrap\Theme;

use ItalyStrap\Config\Config_Interface as Config;

/**
 * Class Thumbnails
 * @package ItalyStrap\Theme
 */
class Thumbnails implements Registrable {

	/**
	 * Image size
	 *
	 * @var array
	 */
	private $image_sizes = array();

	/**
	 * @var Config
	 */
	private $config;

	/**
	 * Init the class
	 *
	 * @param [type] $argument [description].
	 */
	public function __construct( Config $config ) {

		$this->config = $config;

		$this->image_sizes = (array) $this->config->get('image_size');
	}

	/**
	 * @param string $name
	 * @param int $width
	 * @param int $height
	 * @param bool $crop
	 * @return Thumbnails
	 */
	public function addSize( string $name, int $width = 0, int $height = 0, bool $crop = false  ) : self {
		\add_image_size( ...\func_get_args() );
		return $this;
	}

	/**
	 * @param string $name
	 * @return Thumbnails
	 */
	public function removeSize( string $name ) : self {
		\remove_image_size( $name );
		return $this;
	}

	/**
	 * @param string $name
	 * @return bool
	 */
	public function hasSize( string $name ) : bool {
		return \has_image_size( $name );
	}

	/**
	 * Register image size
	 */
	public function register() {

		/**
		 * $content_width is a global variable used by WordPress for max image upload sizes
		 * and media embeds (in pixels).
		 *
		 * Example: If the content area is 640px wide,
		 * set $content_width = 620; so images and videos will not overflow.
		 * Default: 750px is the default ItalyStrap container width.
		 */
		global $content_width;
		if ( ! isset( $content_width ) ) {
			$content_width = $this->config->get( 'content_width' );
		}

		$height = round( $content_width * 3 / 4 );

		/**
		 * 'post-thumbnails' is by default the size displayed for posts, pages and all archives.
		 */
		\set_post_thumbnail_size( $content_width, $height );


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

		$this->setImageSizeFromBreakpoint();

		$this->addImageSize();
	}

	/**
	 * Add image sizes
	 */
	private function addImageSize() {

		$default = [
			'width'		=> 0,
			'height'	=> 0,
			'crop'		=> false,
		];

		foreach ( $this->image_sizes as $name => $params ) {

			$params = \array_merge( $default, $params );

			$this->addSize(
				$name,
				(int) $params['width'],
				(int) $params['height'],
				\boolval( $params['crop'] ) ?? false
			);
		}
	}

	/**
	 * Generate image size from breakpoint
	 */
	private function setImageSizeFromBreakpoint() {

		/**
		 * @todo Da sviluppare meglio
		 * Più che generare una larghezza in base al breackpoint
		 * generare invece una larghezza in base alla colonna contenitore
		 * di misure accettabili: esempio add_image_size( 'one_fourth', 263, 238, true );
		 * Il nome della dimensione usare le frazioni:
		 * 1/2
		 * 1/3
		 * 1/4
		 * 1/6
		 * Non scenderei oltre
		 * Queste dimensioni sono utilizzabili eventualmente nei widget o
		 * nelle pagine archive (quelle per la lista degli articoli)
		 * Creare una funzione che:
		 * Ritorni la larghezza
		 * Calcoli e ritorni l'altezza in base alla proporzione che sarà
		 * inserita come parametro in modo da avere tutti i tagli con le stesse proporzioni.
		 * Deve essere calcolata in base anche al gutter.
		 */
		foreach ( (array) $this->config->get('breakpoint', [] ) as $name => $width ) {
			$this->image_sizes[ $name ] = [
				'width'  => absint( $width ),
				'height' => 9999,
				'crop'   => true,
			];
		}
	}

	/**
	 * Get height
	 *
	 * @param $width
	 * @param $prop
	 * @return int
	 */
	private function getHeight( $width, $prop ) : int {
		return (int) $width / $prop;
	}
}
