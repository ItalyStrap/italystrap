<?php
declare(strict_types=1);

namespace ItalyStrap\Components;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\View\ViewInterface;
use ItalyStrap\Event\SubscriberInterface;

class PostAuthorInfo implements ComponentInterface, SubscriberInterface {

	use SubscribedEventsAware;

	const EVENT_NAME = 'italystrap_after_entry_content';
	const EVENT_PRIORITY = 30;

	private ConfigInterface $config;
	private ViewInterface $view;

	public function __construct( ConfigInterface $config, ViewInterface $view ) {
		$this->config = $config;
		$this->view = $view;
	}

	public function shouldDisplay(): bool {
		return \post_type_supports(  (string)\get_post_type(), 'author' )
			&& \is_singular()
			&& ! \in_array( 'hide_author', $this->config->get('post_content_template'), true );
	}

	public function display(): void {
		echo $this->view->render(null, []);
	}
}
