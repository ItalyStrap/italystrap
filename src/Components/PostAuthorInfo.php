<?php
declare(strict_types=1);

namespace ItalyStrap\Components;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;

class PostAuthorInfo implements ComponentInterface, SubscriberInterface {

	use SubscribedEventsAware;

	public const EVENT_NAME = 'italystrap_after_entry_content';
	public const EVENT_PRIORITY = 30;

	private ConfigInterface $config;
	private AuthorInfo $author;

	public function __construct( ConfigInterface $config, AuthorInfo $author) {
		$this->config = $config;
		$this->author = $author;
	}

	public function shouldDisplay(): bool {
		return \post_type_supports(  (string)\get_post_type(), 'author' )
			&& \is_singular()
			&& ! \in_array( 'hide_author', $this->config->get('post_content_template'), true );
	}

	public function display(): void {
		echo $this->author->render(null, []);
	}
}
