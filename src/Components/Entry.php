<?php
declare(strict_types=1);

namespace ItalyStrap\Components;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\EventDispatcherInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\View\ViewInterface;

class Entry implements ComponentInterface, SubscriberInterface {

	use SubscribedEventsAware;

	public const EVENT_NAME = 'italystrap_entry';
	public const EVENT_PRIORITY = 10;

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
		// Is it a good idea to pass (array) \get_post( null, ARRAY_A ); to data?

		$classes = \get_post_class();
		$classes = $this->classeForPostThumbnail( $classes );
		/**
		 * Remove the 'hentry' css class to prevents error in search console
		 */
		foreach ( $classes as $key => $class ) {
			if ( 'hentry' === $class ) {
				unset( $classes[ $key ] );
			}
		}

		echo $this->view->render( 'posts/entry-post', [
			EventDispatcherInterface::class => $this->dispatcher,
			'id' => \get_the_ID(),
			'class_names' => \join( ' ', $classes )
		] );
	}

	private function classeForPostThumbnail( array $classes ): array {
		/**
		 * If has not a post thumbnail just bail out.
		 */
		if ( ! has_post_thumbnail() ) {
			return $classes;
		}

		$classes[] = 'post-thumbnail-' . $this->config->get( 'post_thumbnail_alignment' );

		return  $classes;
	}
}
