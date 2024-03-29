<?php
declare(strict_types=1);

namespace ItalyStrap\Theme;

use \ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;

final class PostTypeSupportSubscriber implements SubscriberInterface {

	public function getSubscribedEvents(): iterable {
		yield 'init'	=> '__invoke';
	}

	private ConfigInterface $config;

	public function __construct( ConfigInterface $config ) {
		$this->config = $config;
	}

	public function __invoke(): void {
		foreach ( (array)$this->config->get(self::class, []) as $post_type => $features ) {
			\add_post_type_support( $post_type, $features );
		}
	}
}
