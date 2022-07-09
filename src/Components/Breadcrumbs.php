<?php
declare(strict_types=1);

namespace ItalyStrap\Components;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\EventDispatcherInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Theme\Support;
use function ob_get_clean;
use function ob_start;

class Breadcrumbs implements ComponentInterface, SubscriberInterface {

	use SubscribedEventsAware;

	const EVENT_NAME = 'italystrap_before_loop';
	const EVENT_PRIORITY = 10;

	private EventDispatcherInterface $dispatcher;
	private ConfigInterface $config;
	private Support $support;

	public function __construct(
		EventDispatcherInterface $dispatcher,
		ConfigInterface $config,
		Support $support
	) {
		$this->dispatcher = $dispatcher;
		$this->config = $config;
		$this->support = $support;
	}

	public function shouldDisplay(): bool {
		return $this->support->has('breadcrumbs')
			&& \in_array(
				$this->config->get('current_template_file'),
				\explode( ',', $this->config->get( 'breadcrumbs_show_on', '' ) ),
				true
			)
			&& ! \in_array( 'hide_breadcrumbs', $this->config->get('post_content_template'), true );
	}

	public function display(): void {
		$args = [
			// 'home'	=> '<i class="glyphicon glyphicon-home" aria-hidden="true"></i>',
		];

		ob_start();
		$this->dispatcher->dispatch( 'do_breadcrumbs', $args );
		echo (string)ob_get_clean();
	}
}
