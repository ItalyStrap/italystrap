<?php
declare(strict_types=1);

namespace ItalyStrap\Components;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Config\ConfigPostThumbnailProvider;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\View\ViewInterface;
use function get_post_type;
use function in_array;
use function is_singular;
use function ItalyStrap\Core\get_template_settings;
use function post_type_supports;
use function strval;

class FeaturedImage implements ComponentInterface, SubscriberInterface {

	use SubscribedEventsAware;

	public const EVENT_NAME = 'italystrap_entry_content';
	public const EVENT_PRIORITY = 10;
	public const ATTRIBUTES = 'attributes';

	private ConfigInterface $config;
	private ViewInterface $view;

	public function __construct( ConfigInterface $config, ViewInterface $view ) {
		$this->config = $config;
		$this->view = $view;
	}

	public function shouldDisplay(): bool {
		return post_type_supports( (string)get_post_type(), 'thumbnail' )
			&& !in_array( 'hide_thumb', $this->config->get('post_content_template'), true );
	}

	public function display(): void {
//		if ( is_singular() ) {
//			$this->config->add( ConfigPostThumbnailProvider::POST_THUMBNAIL_SIZE, 'post-thumbnail' );
//			$this->config->add( ConfigPostThumbnailProvider::POST_THUMBNAIL_ALIGNMENT, 'aligncenter' );
//		}

		$size = (string)$this->config->get( ConfigPostThumbnailProvider::POST_THUMBNAIL_SIZE );
		$size = $this->getThumbnailSizeForFullWidthLayout($size);

		$alignment = (string)$this->config->get(ConfigPostThumbnailProvider::POST_THUMBNAIL_ALIGNMENT);
		$config = [
			'align' => \str_replace('align', '', $alignment),
			'sizeSlug' => $size,
		];

		echo \do_blocks( '<!-- wp:post-featured-image ' . \json_encode( $config, JSON_THROW_ON_ERROR ) . '  /-->' );
	}

	public function getThumbnailSizeForFullWidthLayout( string $size ): string {
		$site_layout = (string) $this->config->get( 'site_layout' );

		if ( 'full_width' === $site_layout ) {
			return 'full-width';
		}

		if ( \is_page_template( 'full-width.php' ) ) {
			return 'full-width';
		}

		return $size;
	}
}
