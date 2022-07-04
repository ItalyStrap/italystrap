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

final class FeaturedImage implements ComponentInterface, SubscriberInterface {

    const ATTRIBUTES = 'attributes';

	private ConfigInterface $config;

	public function __construct( ConfigInterface $config, ViewInterface $view ) {
		$this->config = $config;
		$this->view = $view;
	}

	public function getSubscribedEvents(): iterable {
		yield 'italystrap_entry_content' => self::DISPLAY_METHOD_NAME;
	}

	public function shouldLoad(): bool {
		return post_type_supports( strval( get_post_type() ), 'thumbnail' )
			&& !in_array( 'hide_thumb', get_template_settings(), true );
	}

	public function display(): void {
		if ( is_singular() ) {
			$this->config->add( 'post_thumbnail_size', 'post-thumbnail' );
			$this->config->add( 'post_thumbnail_alignment', 'aligncenter' );
		}

		$this->config->add( self::ATTRIBUTES, $this->attributes() );

		echo $this->view->render( 'posts/parts/featured-image', $this->config );
	}

    private function attributes(): array {
        return [
            'class' => \trim(
                'featured-image '
                . $this->config->get( 'post_thumbnail_alignment' )
                . ' wp-block-post-featured-image'
            ),
        ];
	}
}
