<?php
declare(strict_types=1);

namespace ItalyStrap\Components;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\View\ViewInterface;

class Content implements SubscriberInterface, ComponentInterface {

	use SubscribedEventsAware;

	public const EVENT_NAME = 'italystrap_entry_content';
	public const EVENT_PRIORITY = 50;

	private ConfigInterface $config;
	private ViewInterface $view;

	public function __construct( ConfigInterface $config, ViewInterface $view  ) {
		$this->config = $config;
		$this->view = $view;
	}

	public function shouldDisplay(): bool {
		return \is_singular()
			&& \post_type_supports(  (string)\get_post_type(), 'editor' )
			&& ! \in_array( 'hide_content', $this->config->get('post_content_template'), true );
	}

	public function display(): void {
		echo \do_blocks( $this->view->render( 'temp/content', [] ) );
	}
}
