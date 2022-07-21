<?php
declare(strict_types=1);

namespace ItalyStrap\Components;

use ItalyStrap\Components\Headers\CustomHeader;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\View\ViewInterface;

class CustomHeaderImage implements ComponentInterface, SubscriberInterface {

	use SubscribedEventsAware;

	const EVENT_NAME = 'italystrap_content_header';
	const EVENT_PRIORITY = 10;

	private ConfigInterface $config;
	private ViewInterface $view;
	private CustomHeader $custom_header;

	public function __construct(
		ConfigInterface $config,
		ViewInterface $view,
		CustomHeader $dispatcher
	) {
		$this->config = $config;
		$this->view = $view;
		$this->custom_header = $dispatcher;
	}

	public function shouldDisplay(): bool {
		return \has_header_image();
	}

	public function display(): void {
		echo \do_blocks( $this->view->render( 'headers/custom-header', $this->custom_header->getData() ) );
	}
}
