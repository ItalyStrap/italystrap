<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Components\Posts;

use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Posts\Events\PostsNotFound;
use ItalyStrap\UI\Infrastructure\ViewBlockInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class NotFound implements ComponentInterface, SubscriberInterface
{
    public function getSubscribedEvents(): iterable
    {
        yield PostsNotFound::class => $this;
    }

    public const TEMPLATE_NAME = 'posts/not-found';

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
        return true;
    }

    public function __invoke(PostsNotFound $event)
    {
        $event->appendContent(
            $this->view->render(self::TEMPLATE_NAME, [
                EventDispatcherInterface::class => $this->dispatcher,
            ])
        );
    }
}
