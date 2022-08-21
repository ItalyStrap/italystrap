<?php
declare(strict_types=1);

namespace ItalyStrap\Components;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\EventDispatcherInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\View\ViewInterface;

class ArchiveHeadline implements ComponentInterface, SubscriberInterface {

	use SubscribedEventsAware;

	public const EVENT_NAME = 'italystrap_before_while';
	public const EVENT_PRIORITY = 20;

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
		return ( \is_archive() || \is_search() ) && ! \is_author();
	}

	public function display(): void {
		echo \do_blocks( $this->view->render( 'misc/archive-headline', [
			EventDispatcherInterface::class => $this->dispatcher,
		] ) );
	}
}
