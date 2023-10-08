<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Components\Posts;

use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Posts\Events\PostsNotFound;
use ItalyStrap\View\ViewInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class NotFound implements ComponentInterface, SubscriberInterface
{
    public function getSubscribedEvents(): iterable
    {
        yield PostsNotFound::class => $this;
    }

    public const TEMPLATE_NAME = 'posts/not-found';

    private ViewInterface $view;
    private EventDispatcherInterface $dispatcher;

    public function __construct(
        ViewInterface $view,
        EventDispatcherInterface $dispatcher
    ) {
        $this->view = $view;
        $this->dispatcher = $dispatcher;
    }

    public function shouldDisplay(): bool
    {
        return true;
    }

    public function __invoke(PostsNotFound $event)
    {
        $event->appendContent($this->view->render(self::TEMPLATE_NAME, [
            EventDispatcherInterface::class => $this->dispatcher,
        ]));
    }
}
