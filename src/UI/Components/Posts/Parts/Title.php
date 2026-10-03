<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Components\Posts\Parts;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Theme\Infrastructure\Json;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Posts\Events\PostContent;
use ItalyStrap\View\ViewInterface;

class Title implements ComponentInterface, SubscriberInterface
{
    public const EVENT_PRIORITY = 20;

    public function getSubscribedEvents(): iterable
    {
        yield PostContent::class => [
            SubscriberInterface::CALLBACK => $this,
            SubscriberInterface::PRIORITY => self::EVENT_PRIORITY,
        ];
    }

    public const TEMPLATE_NAME = 'posts/parts/title';

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
        return \post_type_supports((string)\get_post_type(), 'title')
            && ! \in_array('hide_title', (array)$this->config->get('post_content_template', []), true);
    }

    public function __invoke(PostContent $event): void
    {
        $event->appendContent($this->view->render(self::TEMPLATE_NAME, [
            self::ATTRIBUTES => $this->json->encode([
                "level" => \is_singular() ? 1 : 2,
                "isLink" => true,
                "rel" => "bookmark",
                "className" => "entry-title",
            ]),
        ]));
    }
}
