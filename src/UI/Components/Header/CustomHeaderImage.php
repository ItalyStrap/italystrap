<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Components\Header;

use ItalyStrap\Config\ConfigCustomHeaderProvider;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\HTML\TagInterface;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Header\Events\Content;
use ItalyStrap\UI\Elements\Figure;
use ItalyStrap\UI\Infrastructure\ViewBlockInterface;

class CustomHeaderImage implements ComponentInterface, SubscriberInterface
{
    public const EVENT_PRIORITY = 9;
    private Figure $figure;

    public function getSubscribedEvents(): iterable
    {
        yield Content::class => [
            SubscriberInterface::CALLBACK => $this,
            SubscriberInterface::PRIORITY => self::EVENT_PRIORITY,
        ];
    }

    public const TEMPLATE_NAME = 'header/custom-header';

    public const CONTENT = 'content';
    public const CONTAINER_WIDTH = 'container_width';

    private ConfigInterface $config;
    private ViewBlockInterface $view;
    private TagInterface $tag;

    public function __construct(
        ConfigInterface $config,
        ViewBlockInterface $view,
        TagInterface $tag,
        Figure $figure
    ) {
        $this->config = $config;
        $this->view = $view;
        $this->tag = $tag;
        $this->figure = $figure;
    }

    public function shouldDisplay(): bool
    {
        return \has_header_image();
    }

    public function __invoke(Content $event): void
    {
        $event->appendContent($this->view->render(self::TEMPLATE_NAME, [
            self::CONTENT => $this->printFigureContainer(),
        ]));
    }

    private function printFigureContainer(): string
    {
        return $this->view->render(Figure::TEMPLATE_NAME, [
            TagInterface::class => $this->tag,
            Figure::CONTEXT => self::class,
            Figure::ATTR => [
                'class' => \sprintf(
                    'wp-block-image %s size-large',
                    (string)$this->config->get(ConfigCustomHeaderProvider::CUSTOM_HEADER_ALIGNMENT)
                ),
            ],
            Figure::CONTENT => \get_header_image_tag(),
        ]);
    }

    private function printAnchorTag(): string
    {
        return \sprintf(
            '%s%s%s',
            $this->tag->open('custom-header-anchor', 'a', [
                'href' => \get_home_url(null, '/'),
                'rel' => 'home',
            ]),
            \get_header_image_tag(),
            $this->tag->close('custom-header-anchor')
        );
    }

    private function printForAttachment(): string
    {
        $post_meta_id = \absint(\get_post_meta(\get_the_ID(), '_italystrap_custom_header_id', true));
        return $this->getAttachmentImage($post_meta_id);
    }

    private function getAttachmentImage(int $id, string $size = 'full'): string
    {

        $attr = [
            'class'     => "attachment-$id attachment-header size-header",
            'alt'       => esc_attr($this->config->get('GET_BLOGINFO_NAME')),
        ];

        return \wp_get_attachment_image($id, $size, false, $attr);
    }
}
