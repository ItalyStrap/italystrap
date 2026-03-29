<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Components\Posts\NotFound;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Config\ConfigNotFoundProvider;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Posts\Events\PostsNotFoundContent;
use ItalyStrap\View\ViewInterface;

class Title implements ComponentInterface, SubscriberInterface
{
    public const EVENT_PRIORITY = 20;

    public function getSubscribedEvents(): iterable
    {
        yield PostsNotFoundContent::class => [
            SubscriberInterface::CALLBACK => $this,
            SubscriberInterface::PRIORITY => self::EVENT_PRIORITY,
        ];
    }

    public const TEMPLATE_NAME = 'posts/not-found/title';

    private ConfigInterface $config;
    private ViewInterface $view;

    public function __construct(
        ConfigInterface $config,
        ViewInterface $view
    ) {
        $this->config = $config;
        $this->view = $view;
    }

    public function shouldDisplay(): bool
    {
        return true;
    }

    public function __invoke(PostsNotFoundContent $event): void
    {
        $event->appendContent($this->view->render(self::TEMPLATE_NAME, [
            'content' => (string)$this->config->get(ConfigNotFoundProvider::TITLE),
        ]));
    }
}
