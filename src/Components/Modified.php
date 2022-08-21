<?php
declare(strict_types=1);

namespace ItalyStrap\Components;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\View\ViewInterface;

class Modified implements SubscriberInterface, ComponentInterface {

	use SubscribedEventsAware;

	public const EVENT_NAME = 'italystrap_entry_content';
	public const EVENT_PRIORITY = 60;

	private ConfigInterface $config;
	private ViewInterface $view;

	public function __construct( ConfigInterface $config, ViewInterface $view  ) {
		$this->config = $config;
		$this->view = $view;
	}

	public function shouldDisplay(): bool {
		return true;
	}

	public function display(): void {
		echo \do_blocks( $this->view->render( 'posts/parts/modified', [] ) );
	}
}
