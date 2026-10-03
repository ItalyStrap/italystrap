<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Components\Archive;

use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Posts\Events\PostsContentBefore;
use ItalyStrap\View\ViewInterface;

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

    public const TEMPLATE_NAME = 'archive/archive-headline';

    private ViewInterface $view;

    public function __construct(
        ViewInterface $view
    ) {
        $this->view = $view;
    }

    public function shouldDisplay(): bool
    {
        return \is_archive() && ! \is_author();
    }

    public function __invoke(PostsContentBefore $event): void
    {
        $event->appendContent($this->view->render(self::TEMPLATE_NAME, []));
    }
}
