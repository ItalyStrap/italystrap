<?php
declare(strict_types=1);

namespace ItalyStrap\Components;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\View\ViewInterface;
use ItalyStrap\Event\SubscriberInterface;

class ArchiveAuthorInfo implements ComponentInterface, SubscriberInterface {

	use SubscribedEventsAware;

	private ConfigInterface $config;
	private ViewInterface $view;

	public const EVENT_NAME = 'italystrap_before_loop';
	public const EVENT_PRIORITY = 20;

	public function __construct( ConfigInterface $config, ViewInterface $view ) {
		$this->config = $config;
		$this->view = $view;
	}

	public function shouldDisplay(): bool {
		return \is_author();
	}

	public function display(): void {
		echo $this->view->render(null, []);
	}
}
