<?php
/**
 * Class Image size API
 *
 * This class handle the image size in WordPress
 *
 * @link [URL]
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Custom\Image;

use ItalyStrap\Event\Subscriber_Interface;
use ItalyStrap\Config\Config_Interface;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

/**
 * Class definition
 */
class Size implements Subscriber_Interface {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked after_setup_theme - 10
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		return array(
			// 'hook_name'							=> 'method_name',
			// 'after_setup_theme'	=> array(
			// 	'function_to_add'	=> 'register',
			// 	'priority'			=> 10,
			// ),
//			'italystrap_plugin_app_loaded'	=> 'register',
			'italystrap_theme_load'	=> [
				'function_to_add'		=> 'register',
				'priority'				=> 20,
				'accepted_args'			=> null,
			],
		);
	}

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
	function __construct( Config_Interface $config ) {

		$this->theme_mods = $config->all();

		$this->image_sizes = (array) $this->theme_mods['image_size'];
	}

	/**
	 * Generate image size from breakpoint
	 */
	public function get_image_size_from_breakpoint() {

		/**
		 * Ho un'idea migliore
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
	 * Get height
	 *
	 * @param  string $value [description]
	 * @return string        [description]
	 */
	public function get_height( $width, $prop ) {
		return (int) $width / $prop;
	}

	/**
	 * Add image sizes
	 *
	 * @param  array $image_sizes [description]
	 * @return string        [description]
	 */
	protected function add( array $image_sizes ) {

		foreach ( $image_sizes as $name => $params ) {
			$this->add_image_size( $name, (array) $params );
		}
	}

	/**
	 * Add image sizes
	 *
	 * @param  array $image_sizes [description]
	 * @return string        [description]
	 */
	protected function add_image_size( $name, array $params ) {

		if ( ! isset( $params['width'] ) || ! isset( $params['height'] ) ) {
			return;
		}

		add_image_size(
			$name,
			(int) $params['width'],
			(int) $params['height'],
			isset( $params['crop'] ) ? (bool) $params['crop'] : false
		);
	}

	/**
	 * Register image size
	 */
	public function register() {

		$this->get_image_size_from_breakpoint();

		$this->add( $this->image_sizes );

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
