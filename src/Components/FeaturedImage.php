<?php
declare(strict_types=1);

namespace ItalyStrap\Components;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\View\ViewInterface;
use function get_post_type;
use function in_array;
use function is_singular;
use function ItalyStrap\Core\get_template_settings;
use function post_type_supports;
use function strval;

class FeaturedImage implements ComponentInterface, SubscriberInterface {

	const ATTRIBUTES = 'attributes';

	private ConfigInterface $config;
	private ViewInterface $view;

	public function __construct( ConfigInterface $config, ViewInterface $view ) {
		$this->config = $config;
		$this->view = $view;
	}

	public function getSubscribedEvents(): iterable {
		yield 'italystrap_entry_content' => self::DISPLAY_METHOD_NAME;
	}

	public function shouldDisplay(): bool {
		return post_type_supports( (string)get_post_type(), 'thumbnail' )
			&& !in_array( 'hide_thumb', $this->config->get('post_content_template'), true );
	}

	public function display(): void {
		if ( is_singular() ) {
			$this->config->add( 'post_thumbnail_size', 'post-thumbnail' );
			$this->config->add( 'post_thumbnail_alignment', 'aligncenter' );
		}

		$size = $this->config->get( 'post_thumbnail_size' );
		$config = [
			'align' => 'full',
			'sizeSlug' => $size, // default 'post-thumbnail',
			'className' => '',
		];

		echo \do_blocks( '<!-- wp:post-featured-image ' . \json_encode( $config ) . '  /-->' );
	}
}
