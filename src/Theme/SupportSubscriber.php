<?php
declare(strict_types=1);

namespace ItalyStrap\Theme;

use \ItalyStrap\Config\ConfigInterface as Config;
use ItalyStrap\Event\SubscriberInterface;

final class SupportSubscriber implements Registrable, SubscriberInterface {

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
	 * @var Support
	 */
	private Support $support;

	/**
	 * Init sidebars registration
	 */
	public function __construct( Config $config, Support $support ) {
		$this->config = $config;
		$this->support = $support;
	}

	/**
	 * Add theme supports
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support
	 *
	 * @return void
	 */
	public function register() {
		foreach ( $this->config as $feature => $parameters ) {
			if ( \is_string( $parameters ) ) {
				$this->support->add( $parameters );
			} else {
				$this->support->add( $feature, $parameters );
			}
		}
	}
}
