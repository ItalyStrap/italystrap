<?php
declare(strict_types=1);

namespace ItalyStrap\Components;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\EventDispatcherInterface;
use ItalyStrap\View\ViewInterface;

class NavMenuHeader implements ComponentInterface, \ItalyStrap\Event\SubscriberInterface {

	use SubscribedEventsAware;

	const EVENT_NAME = 'italystrap_before_navmenu';
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
		echo $this->view->render('navigation/header', [
			EventDispatcherInterface::class => $this->dispatcher,
		]);
	}
}
