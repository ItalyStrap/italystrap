<?php
declare(strict_types=1);

namespace ItalyStrap\Theme;

use ItalyStrap\Asset\Asset;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Event\Manager as Event;

class Assets implements Registrable, SubscriberInterface
{
	/**
	 * @var Asset
	 */
	private $style;
	/**
	 * @var Asset
	 */
	private $script;

	/**
	 * @var array Asset
	 */
	private $assets = [];

	/**
	 * @inheritDoc
	 */
	public function register(): void {
		\array_walk($this->assets, function ( Asset $asset, $key) {
			$asset->register_all();
		});
	}

	/**
	 * @inheritDoc
	 */
	public function getSubscribedEvents(): array {
		return [
			'wp_enqueue_scripts'	=> [
				Event::CALLBACK	=> static::CALLBACK,
			],
		];
	}

	public function withAssets( Asset ...$assets ) {
		$this->assets = \array_merge($assets, $this->assets);
	}
}