<?php
declare(strict_types=1);

namespace ItalyStrap\Components;

use ItalyStrap\Components\Navigations\Navbar;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\EventDispatcherInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\View\ViewInterface;

class MainNavigation implements ComponentInterface, SubscriberInterface {

	use SubscribedEventsAware;

	const EVENT_NAME = 'italystrap_after_header';
	const EVENT_PRIORITY = 10;

	private ConfigInterface $config;
	private ViewInterface $view;
	private Navigations\Navbar $navbar;

	public function __construct(
		ConfigInterface $config,
		ViewInterface $view,
		Navigations\Navbar $navbar
	) {
		$this->config = $config;
		$this->view = $view;
		$this->navbar = $navbar;
	}

	public function shouldDisplay(): bool {
		return true;
	}

	public function display(): void {
		echo \do_blocks( $this->view->render( 'navigation', [
		] ) );
	}
}
