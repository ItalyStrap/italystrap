<?php
declare(strict_types=1);

namespace ItalyStrap\Theme;

use ItalyStrap\Config\ConfigInterface as Config;
use ItalyStrap\Event\SubscriberInterface;

class NavMenusSubscriber implements Registrable, SubscriberInterface {

	/**
	 * @inheritDoc
	 */
	public function getSubscribedEvents(): iterable {
		yield 'italystrap_theme_load'	=> [
			static::CALLBACK	=> static::REGISTER_CB,
			static::PRIORITY	=> 20,
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
		\register_nav_menus( $this->config->toArray() );
	}
}
