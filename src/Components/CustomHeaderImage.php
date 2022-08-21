<?php
declare(strict_types=1);

namespace ItalyStrap\Components;

use ItalyStrap\Config\ConfigCustomHeaderProvider;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\EventDispatcherInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\HTML\Tag;
use ItalyStrap\View\ViewInterface;

class CustomHeaderImage implements ComponentInterface, SubscriberInterface {

	use SubscribedEventsAware;

	public const EVENT_NAME = 'italystrap_content_header';
	public const EVENT_PRIORITY = 10;

	public const CONTENT = 'content';
	public const CONTAINER_WIDTH = 'container_width';

	private ConfigInterface $config;
	private ViewInterface $view;
	private Tag $tag;
	private EventDispatcherInterface $dispatcher;

	public function __construct(
		ConfigInterface $config,
		ViewInterface $view,
		Tag $tag,
		EventDispatcherInterface $dispatcher
	) {
		$this->config = $config;
		$this->view = $view;
		$this->tag = $tag;
		$this->dispatcher = $dispatcher;
	}

	public function shouldDisplay(): bool {
		return \has_header_image();
	}

	public function display(): void {
		echo \do_blocks( $this->view->render( 'headers/custom-header', [
			EventDispatcherInterface::class => $this->dispatcher,
			self::CONTENT => $this->printFigureContainer(),
		] ) );
	}

	private function printFigureContainer(): string {
		return $this->view->render('figure', [
			Tag::class => $this->tag,
			'figureAttributes' => [
				'class' => \sprintf(
					'wp-block-image %s size-large',
					(string)$this->config->get(ConfigCustomHeaderProvider::CUSTOM_HEADER_ALIGNMENT)
				),
			],
			self::CONTENT => \get_header_image_tag(),
		]);
	}

	private function printAnchorTag(): string {
		return \sprintf(
			'%s%s%s',
			$this->tag->open( 'custom-header-anchor', 'a', [
				'href' => \get_home_url( null, '/' ),
				'rel' => 'home',
			] ),
			\get_header_image_tag(),
			$this->tag->close('custom-header-anchor')
		);
	}

	private function printForAttachment(): string {
		$post_meta_id = \absint( \get_post_meta( \get_the_ID(), '_italystrap_custom_header_id', true ) );
		return $this->getAttachmentImage($post_meta_id);
	}

	private function getAttachmentImage( int $id, string $size = 'full' ): string {

		$attr = [
			'class'		=> "attachment-$id attachment-header size-header",
			'alt'		=> esc_attr( $this->config->get( 'GET_BLOGINFO_NAME' ) ),
		];

		return \wp_get_attachment_image( $id, $size, false, $attr );
	}
}
