<?php
/**
 * Theme Init Class
 *
 * This class is under development, consider this an ALPHA version,
 * some functionality can be changed in future, especially the filter name.
 *
 * @link [URL]
 * @since 3.0.5
 *
 * @package ItalyStrap
 */
declare(strict_types=1);

namespace ItalyStrap\Theme;

use ItalyStrap\Config\ConfigInterface as Config;
use ItalyStrap\Event\Manager as Event;
use ItalyStrap\Event\Subscriber_Interface;

/**
 * Theme init
 */
class Starter implements Subscriber_Interface {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		return [
			// 'hook_name'							=> 'method_name',
			'italystrap_theme_load'	=> [
				Event::CALLBACK	=> 'start',
				Event::PRIORITY	=> 20,
			],
			'init'					=> 'start',
		];
	}

	/**
	 * @var Config
	 */
	private $config;
	private $thumbnails;
	private $type_support;

	/**
	 * Init some functionality
	 * @param Config $config
	 * @param Thumbnails $thumbnails
	 * @param TypeSupport $type_support
	 */
	public function __construct(
		Config $config,
		Thumbnails $thumbnails,
		TypeSupport $type_support
	) {
		$this->config = $config;
		$this->thumbnails = $thumbnails;
		$this->type_support = $type_support;
	}

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 * customiz
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	public function start() {
		$method = \current_filter();
		if ( \method_exists( $this, $method ) ) {
			$this->$method();
		}
	}

	/**
	 *
	 */
	private function italystrap_theme_load() {

		/**
		 * Make theme available for translation.
		 */
		\load_theme_textdomain( 'italystrap', $this->config->get( 'PARENTPATH' ) . '/languages' );

//		if ( is_child_theme() ) {
//			\load_child_theme_textdomain( 'CHILD', $this->config->get( 'CHILDPATH' ) . '/languages' );
//		}

		$this->thumbnails->register();
	}

	/**
	 * Add post type support
	 * @fire on init
	 */
	private function init() {
		$this->type_support->register();
	}
}
