<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Components\Posts\NotFound;

use ItalyStrap\Components\SubscribedEventsAware;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Config\ConfigNotFoundProvider;
use ItalyStrap\Event\GlobalDispatcherInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\HTML\TagInterface;
use ItalyStrap\Theme\Infrastructure\Config\ConfigPostThumbnailProvider;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Posts\Events\PostsNotFoundContent;
use ItalyStrap\UI\Elements\Figure;
use ItalyStrap\View\ViewInterface;

class Image implements ComponentInterface, SubscriberInterface
{
    use SubscribedEventsAware;

    public const EVENT_NAME = 'italystrap_entry_content_none';
    public const EVENT_PRIORITY = 10;
    private int $imageId;
    private Figure $figure;

    public function getSubscribedEvents(): iterable
    {
        yield PostsNotFoundContent::class => [
            SubscriberInterface::CALLBACK => $this,
            SubscriberInterface::PRIORITY => self::EVENT_PRIORITY,
        ];
    }

    public const TEMPLATE_NAME = 'elements/figure';

    private ConfigInterface $config;
    private ViewInterface $view;
    private GlobalDispatcherInterface $dispatcher;
    private TagInterface $tag;

    public function __construct(
        ConfigInterface $config,
        ViewInterface $view,
        GlobalDispatcherInterface $dispatcher,
        TagInterface $tag,
        Figure $figure
    ) {
        $this->config = $config;
        $this->view = $view;
        $this->dispatcher = $dispatcher;
        $this->tag = $tag;
        $this->figure = $figure;
        $this->imageId = (int)$this->config->get(ConfigNotFoundProvider::ID_IMAGE, 0);
    }

    public function shouldDisplay(): bool
    {
        return \is_404()
            && 'show' === (string)$this->config->get(ConfigNotFoundProvider::SHOW_IMAGE, '')
            && $this->hasImage();
    }

    public function __invoke(PostsNotFoundContent $event): void
    {
        $this->figure->withContext(self::class);
        $this->figure->withContent($this->content());
        $this->figure->withAttributes([
            'class' => \sprintf(
                '%s wp-block-post-featured-image',
                (string)$this->config->get(ConfigPostThumbnailProvider::POST_THUMBNAIL_ALIGNMENT),
            ),
        ]);

        $event->appendContent((string)$this->figure);
    }

    private function content()
    {
        $size = (string)$this->config->get(ConfigPostThumbnailProvider::POST_THUMBNAIL_SIZE);
        $html = \wp_get_attachment_image(
            $this->imageId,
            $size,
            false,
            [
                'class' => "attachment-{$size} size-{$size} wp-post-image",
            ]
        );

        return $this->dispatcher->filter('italystrap_lazyload_images_in_this_content', $html);
    }

    private function hasImage(): bool
    {
        return (bool)$this->imageId;
    }
}
