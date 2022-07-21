<?php
declare(strict_types=1);

namespace ItalyStrap\Components;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\EventDispatcherInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\View\ViewInterface;

class SiteLogo implements ComponentInterface, SubscriberInterface {

	use SubscribedEventsAware;

	const EVENT_NAME = 'italystrap';
	const EVENT_PRIORITY = 10;

	private ConfigInterface $config;
	private ViewInterface $view;
	private EventDispatcherInterface $dispatcher;

	public function __construct(
		ConfigInterface $config,
		ViewInterface $view,
		EventDispatcherInterface $dispatcher
	) {
		$this->config = $config;
		$this->view = $view;
		$this->dispatcher = $dispatcher;
	}

	public function shouldDisplay(): bool {
		return true;
	}

	public function display(): void {
		echo \do_blocks( '<!-- wp:site-logo {"width":45,"shouldSyncIcon":true,"className":"is-style-default"} /-->' );
	}
}
