<?php
declare(strict_types=1);

namespace ItalyStrap\Theme;

use \ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;

final class SupportSubscriber implements Registrable, SubscriberInterface {

	private ConfigInterface $config;
	private Support $support;

	public function getSubscribedEvents(): iterable {
		yield 'italystrap_theme_load'	=> [
			static::CALLBACK	=> static::REGISTER_CB,
			static::PRIORITY	=> 20,
		];
	}

	public function __construct( ConfigInterface $config, Support $support ) {
		$this->config = $config;
		$this->support = $support;
	}

	/**
	 * Add theme supports
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support
	 * @return void
	 */
	public function register(): void {
		foreach ( (array) $this->config->get(self::class) as $feature => $parameters ) {
			if ( \is_string( $parameters ) ) {
				$this->support->add( $parameters );
			} else {
				$this->support->add( $feature, $parameters );
			}
		}
	}
}
