<?php
declare(strict_types=1);

namespace ItalyStrap\Theme;

use ItalyStrap\Config\ConfigInterface as Config;
use ItalyStrap\Event\SubscriberInterface;
use function absint;
use function add_image_size;
use function array_merge;
use function array_walk;
use function boolval;
use function func_get_args;
use function has_image_size;
use function intval;
use function remove_image_size;
use function set_post_thumbnail_size;

/**
 * Class Thumbnails
 * @package ItalyStrap\Theme
 */
class Thumbnails implements ThumbnailsInterface, Registrable, SubscriberInterface {

	const WIDTH = 'width';
	const HEIGHT = 'height';
	const CROP = 'crop';

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @return array
	 */
	public function getSubscribedEvents(): array {

		return [
			// 'hook_name'							=> 'method_name',
			'italystrap_theme_load'	=> [
				static::CALLBACK	=> self::REGISTER_CB,
				static::PRIORITY	=> 20,
			],
		];
	}

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
	 * @param Config $config
	 */
	public function __construct( Config $config ) {

		$this->config = $config;

		$this->image_sizes = (array) $this->config->sizes;
	}

	/**
	 * @inheritDoc
	 */
	public function addSize( string $name, int $width = 0, int $height = 0, bool $crop = false  ): self {
		add_image_size( ...func_get_args() );
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function removeSize( string $name ): self {
		remove_image_size( $name );
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function hasSize( string $name ): bool {
		return has_image_size( $name );
	}

	/**
	 * Register image size
	 *
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
	 * @example
	 * 	add_image_size(
	 * 		'medium',
	 * 		get_option( 'medium_size_w' ),
	 * 		get_option( 'medium_size_h' ),
	 * 		true
	 * ); // For cropping the default image size.
	 *
	 * Maybe first remove_image_size and then add_image_size it's better
	 * @link http://wordpress.stackexchange.com/questions/30965/set-default-image-sizes-in-wordpress-to-hard-crop
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
			$content_width = $this->config->content_width;
		}

		/**
		 * 'post-thumbnails' is by default the size displayed for posts, pages and all archives.
		 */
		set_post_thumbnail_size( $content_width, intval( $content_width * 3 / 4 ) );

		$this->registerImageSize();
	}

	/**
	 * Add image sizes
	 */
	private function registerImageSize() {
		array_walk( $this->image_sizes, function ( $params, $name ) {
			$params = array_merge( $this->getDefaultImageParams(), $params );

			$this->addSize(
				$name,
				intval( $params[ self::WIDTH ] ),
				intval( $params[ self::HEIGHT ] ),
				boolval( $params[ self::CROP ] ) ?? false
			);
		}  );
	}
	/**
	 * @return array
	 */
	private function getDefaultImageParams(): array {
		$default = [
			self::WIDTH		=> 0,
			self::HEIGHT	=> 0,
			self::CROP		=> false,
		];

		return $default;
	}

	/**
	 * Get height
	 *
	 * @param int $width
	 * @param int $prop
	 * @return int
	 */
	private function calculateHeight( int $width, int $prop ): int {
		return intval( $width / $prop );
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
				self::WIDTH  => absint( $width ),
				self::HEIGHT => 9999,
				self::CROP   => true,
			];
		}
	}
}
