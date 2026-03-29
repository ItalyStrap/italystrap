<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Components\Posts\Parts;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Theme\Infrastructure\Config\ConfigPostThumbnailProvider;
use ItalyStrap\Theme\Infrastructure\Json;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Posts\Events\PostContent;
use ItalyStrap\View\ViewInterface;

use function get_post_type;
use function in_array;
use function post_type_supports;

class FeaturedImage implements ComponentInterface, SubscriberInterface
{
    public const EVENT_PRIORITY = 10;

    public function getSubscribedEvents(): iterable
    {
        yield PostContent::class => [
            SubscriberInterface::CALLBACK => $this,
            SubscriberInterface::PRIORITY => self::EVENT_PRIORITY,
        ];
    }

    public const TEMPLATE_NAME = 'posts/parts/featured-image';

    public const ATTRIBUTES = 'attributes';

    private ConfigInterface $config;
    private ViewInterface $view;
    private Json $json;

    public function __construct(
        ConfigInterface $config,
        ViewInterface $view,
        Json $json
    ) {
        $this->config = $config;
        $this->view = $view;
        $this->json = $json;
    }

    public function shouldDisplay(): bool
    {
        return post_type_supports((string)get_post_type(), 'thumbnail')
            && !in_array('hide_thumb', (array)$this->config->get('post_content_template', []), true);
    }

    public function __invoke(PostContent $event): void
    {
//      if ( is_singular() ) {
//          $this->config->add( ConfigPostThumbnailProvider::POST_THUMBNAIL_SIZE, 'post-thumbnail' );
//          $this->config->add( ConfigPostThumbnailProvider::POST_THUMBNAIL_ALIGNMENT, 'aligncenter' );
//      }

        $size = (string)$this->config->get(ConfigPostThumbnailProvider::POST_THUMBNAIL_SIZE);
        $size = $this->getThumbnailSizeForFullWidthLayout($size);
        $alignment = (string)$this->config->get(ConfigPostThumbnailProvider::POST_THUMBNAIL_ALIGNMENT);

        $event->appendContent($this->view->render(self::TEMPLATE_NAME, [
            self::ATTRIBUTES => $this->json->encode([
                'align' => \str_replace('align', '', $alignment),
                'sizeSlug' => $size,
            ]),
        ]));
    }

    public function getThumbnailSizeForFullWidthLayout(string $size): string
    {
        $site_layout = (string) $this->config->get('site_layout');

        if ('full_width' === $site_layout) {
            return 'full-width';
        }

        if (\is_page_template('full-width.php')) {
            return 'full-width';
        }

        return $size;
    }
}
