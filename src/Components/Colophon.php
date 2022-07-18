<?php
declare(strict_types=1);

namespace ItalyStrap\Components;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\EventDispatcherInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\View\ViewInterface;

class Colophon implements ComponentInterface, SubscriberInterface {

	use SubscribedEventsAware;

	const EVENT_NAME = 'italystrap_footer';
	const EVENT_PRIORITY = 20;

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
		echo \do_blocks( $this->view->render( 'footers/colophon', [
			'content'	=> $this->dispatcher->filter(
				'italystrap_colophon_output',
				$this->config->get( 'colophon', '' )
			),
		] ) );
	}
}
