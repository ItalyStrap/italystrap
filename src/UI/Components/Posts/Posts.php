<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Components\Posts;

use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Main\Events\Content;
use ItalyStrap\View\ViewInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class Posts implements ComponentInterface, SubscriberInterface
{
    public function getSubscribedEvents(): iterable
    {
        yield Content::class => $this;
    }

    public const TEMPLATE_NAME = 'posts/posts';

    public function __construct(
        private readonly ViewInterface $view,
        private readonly EventDispatcherInterface $dispatcher,
    ) {
    }

    public function shouldDisplay(): bool
    {
        return true;
    }

    public function __invoke(Content $event): void
    {
        $event->appendContent($this->view->render(self::TEMPLATE_NAME, [
            EventDispatcherInterface::class => $this->dispatcher,
        ]));
    }
}
