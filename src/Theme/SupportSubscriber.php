<?php
declare(strict_types=1);

namespace ItalyStrap\Theme;

use \ItalyStrap\Config\ConfigInterface as Config;
use ItalyStrap\Event\SubscriberInterface;

class SupportSubscriber implements Registrable, SubscriberInterface {

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
	 * Add theme supports
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support
	 */
	public function register() {
		foreach ( $this->config as $feature => $parameters ) {
			if ( \is_string( $parameters ) ) {
				\add_theme_support( $parameters );
			} else {
				\add_theme_support( $feature, $parameters );
			}
		}
	}
}
