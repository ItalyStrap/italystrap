<?php
declare(strict_types=1);

namespace ItalyStrap\Theme;


use ItalyStrap\Event\SubscriberInterface;

class Assets implements Registrable, SubscriberInterface
{

	/**
	 * Assets constructor.
	 */
	public function __construct() {
	}

	/**
	 * @inheritDoc
	 */
	public function register() {
		// TODO: Implement register() method.
	}

	/**
	 * @inheritDoc
	 */
	public function getSubscribedEvents(): array {
		// TODO: Implement getSubscribedEvents() method.
	}
}