<?php
declare(strict_types=1);

namespace ItalyStrap\Components;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Config\ConfigNotFoundProvider;
use ItalyStrap\Config\ConfigPostThumbnailProvider;
use ItalyStrap\Event\EventDispatcherInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\HTML\Tag;
use ItalyStrap\View\ViewInterface;

class EntryNoneImage implements ComponentInterface, SubscriberInterface {

	use SubscribedEventsAware;

	const EVENT_NAME = 'italystrap_entry_content_none';
	const EVENT_PRIORITY = 10;

	private ConfigInterface $config;
	private ViewInterface $view;
	private EventDispatcherInterface $dispatcher;
	private Tag $tag;

	public function __construct(
		ConfigInterface $config,
		ViewInterface $view,
		EventDispatcherInterface $dispatcher,
		Tag $tag
	) {
		$this->config = $config;
		$this->view = $view;
		$this->dispatcher = $dispatcher;
		$this->tag = $tag;
	}

	public function shouldDisplay(): bool {
		return \is_404() && 'show' === (string)$this->config->get(ConfigNotFoundProvider::SHOW_IMAGE, '') ;
	}

	public function display(): void {
		echo $this->view->render( 'figure', [
			Tag::class => $this->tag,
			'context' => self::class,
			'figureAttributes' => [
				'class' => \sprintf(
					'%s wp-block-post-featured-image',
					(string)$this->config->get(ConfigPostThumbnailProvider::POST_THUMBNAIL_ALIGNMENT),
				),
			],
			'content' => $this->content(),
		] );
	}

	private function content() {
		$size = (string)$this->config->get(ConfigPostThumbnailProvider::POST_THUMBNAIL_SIZE);
		$html = \wp_get_attachment_image(
			(int)$this->config->get(ConfigNotFoundProvider::ID_IMAGE, 0),
			$size,
			false,
			[
				'class' => "attachment-{$size} size-{$size} wp-post-image",
			]
		);

		return $this->dispatcher->filter('italystrap_lazyload_images_in_this_content', $html);
	}
}
