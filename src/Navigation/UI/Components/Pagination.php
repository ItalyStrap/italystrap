<?php

declare(strict_types=1);

namespace ItalyStrap\Navigation\UI\Components;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Posts\Events\PostsContentAfter;
use ItalyStrap\View\ViewInterface;

class Pagination implements SubscriberInterface, ComponentInterface
{
    public const EVENT_PRIORITY = 10;

    public const TEMPLATE_NAME = 'navigation/pagination';

    public function getSubscribedEvents(): iterable
    {
        yield PostsContentAfter::class => [
            SubscriberInterface::CALLBACK => $this,
            SubscriberInterface::PRIORITY => self::EVENT_PRIORITY,
        ];
    }

    private ConfigInterface $config;
    private ViewInterface $view;

    public function __construct(ConfigInterface $config, ViewInterface $view)
    {
        $this->config = $config;
        $this->view = $view;
    }

    public function shouldDisplay(): bool
    {
        return ! \is_404();
    }

    public function __invoke(PostsContentAfter $event): void
    {
        /**
         * Appended as block markup instead of being rendered here: dispatched inside the query
         * block, the pagination blocks get its context and paginate the main query.
         */
        $event->appendContent($this->view->render(self::TEMPLATE_NAME));
    }
}
