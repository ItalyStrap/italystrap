<?php
declare(strict_types=1);

namespace ItalyStrap\Components;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Config\ConfigSidebarProvider;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\View\ViewInterface;

class FooterWidgetArea implements ComponentInterface, SubscriberInterface {

	use SubscribedEventsAware;

	public const EVENT_NAME = 'italystrap_footer';
	public const EVENT_PRIORITY = 10;

	private ConfigInterface $config;
	private ViewInterface $view;

	public function __construct(
		ConfigInterface $config,
		ViewInterface $view
	) {
		$this->config = $config;
		$this->view = $view;
	}

	public function shouldDisplay(): bool {
		return true;
	}

	public function display(): void {
		echo \do_blocks( $this->view->render( 'footers/widget-area', [
			'footer_sidebars' => ConfigSidebarProvider::FOOTERS,
		] ) );
	}
}
