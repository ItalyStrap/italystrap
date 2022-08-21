<?php
declare(strict_types=1);

namespace ItalyStrap\Components;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\EventDispatcherInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\View\ViewInterface;

class MiscNavigation implements ComponentInterface, SubscriberInterface {

	use SubscribedEventsAware;

	public const EVENT_NAME = 'italystrap_before_header';
	public const EVENT_PRIORITY = 10;

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
		return \has_nav_menu( 'info-menu' )
			&& \has_nav_menu( 'social-menu' );
	}

	public function display(): void {
		echo \do_blocks( $this->view->render( 'headers/navbar-top', [
			EventDispatcherInterface::class => $this->dispatcher,
		] ) );
	}
}
