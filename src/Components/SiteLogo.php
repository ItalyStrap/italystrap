<?php
declare(strict_types=1);

namespace ItalyStrap\Components;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Config\ConfigSiteLogoProvider;
use ItalyStrap\Event\EventDispatcherInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Theme\ThumbnailsSubscriber;
use ItalyStrap\View\ViewInterface;

class SiteLogo implements ComponentInterface, SubscriberInterface {

	use SubscribedEventsAware;

	const EVENT_NAME = 'italystrap_navbar_brand_output';
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
		$size_name_registered = (string)$this->config->get(ConfigSiteLogoProvider::BRAND_IMAGE_SIZE);
		$width = (int)$this->config->get(ThumbnailsSubscriber::class . '.' . $size_name_registered . '.width');
		echo \do_blocks(
			'<!-- wp:site-logo {"width":' . $width . ',"shouldSyncIcon":false,"className":"is-style-default"} /-->'
		);
	}
}
