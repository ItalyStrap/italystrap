<?php

declare(strict_types=1);

namespace ItalyStrap\Components;

use ItalyStrap\Event\EventDispatcherInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Posts\Events\PostsContentBefore;
use ItalyStrap\UI\Infrastructure\ViewBlockInterface;

class ArchiveHeadline implements ComponentInterface, SubscriberInterface
{
    public const EVENT_PRIORITY = 20;

    public function getSubscribedEvents(): iterable
    {
        yield PostsContentBefore::class => [
            SubscriberInterface::CALLBACK => $this,
            SubscriberInterface::PRIORITY => self::EVENT_PRIORITY,
        ];
    }

    public const TEMPLATE_NAME = 'misc/archive-headline';

    private ViewBlockInterface $view;
    private EventDispatcherInterface $dispatcher;

    public function __construct(
        ViewBlockInterface $view,
        EventDispatcherInterface $dispatcher
    ) {
        $this->view = $view;
        $this->dispatcher = $dispatcher;
    }

    public function shouldDisplay(): bool
    {
        return ( \is_archive() || \is_search() ) && ! \is_author();
    }

    public function __invoke(PostsContentBefore $event): void
    {
        $event->appendContent($this->view->render(self::TEMPLATE_NAME, [
            EventDispatcherInterface::class => $this->dispatcher,
        ]));
    }
}
