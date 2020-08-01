<?php
declare(strict_types=1);

namespace ItalyStrap\Theme;

use \ItalyStrap\Config\ConfigInterface as Config;
use ItalyStrap\Event\SubscriberInterface;

class SupportSubscriber implements Registrable, SubscriberInterface {

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
				static::CALLBACK	=> static::REGISTER_CB,
				static::PRIORITY	=> 20,
			],
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