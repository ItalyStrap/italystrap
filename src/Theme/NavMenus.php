<?php
declare(strict_types=1);

namespace ItalyStrap\Theme;

use ItalyStrap\Config\ConfigInterface as Config;
use ItalyStrap\Event\Subscriber_Interface;
use ItalyStrap\Event\Manager as Event;

class NavMenus implements Registrable, Subscriber_Interface {

	/**
	 * @inheritDoc
	 */
	public static function get_subscribed_events() {
		return [
			// 'hook_name'							=> 'method_name',
			'italystrap_theme_load'	=> [
				Event::CALLBACK	=> static::CALLBACK,
				Event::PRIORITY	=> 20,
			]
		];
	}

	/**
	 * @var Config
	 */
	private $config;

	/**
	 * Init sidebars registration
	 */
	public function __construct( Config $config ) {
		$this->config = $config;
	}

	/**
	 * The class that implements this can be registered
	 */
	public function register() {
		\register_nav_menus( $this->config->all() );
	}
}
