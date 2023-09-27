<?php

declare(strict_types=1);

namespace ItalyStrap\Components\Footer;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Event\EventDispatcherInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\View\ViewInterface;

class Footer implements ComponentInterface, SubscriberInterface
{
    public function getSubscribedEvents(): iterable
    {
        yield \ItalyStrap\Components\Main\Events\Footer::class => $this;
    }

    public const TEMPLATE_NAME = 'footer/footer';
    private ViewInterface $view;
    private EventDispatcherInterface $globalDispatcher;

    private \Psr\EventDispatcher\EventDispatcherInterface $dispatcher;

    public function __construct(
        ViewInterface $view,
        EventDispatcherInterface $globalDispatcher,
        \Psr\EventDispatcher\EventDispatcherInterface $dispatcher
    ) {
        $this->view = $view;
        $this->globalDispatcher = $globalDispatcher;
        $this->dispatcher = $dispatcher;
    }

    public function shouldDisplay(): bool
    {
        return true;
    }

    public function __invoke(\ItalyStrap\Components\Main\Events\Footer $event)
    {
        $event->appendContent($this->view->render(self::TEMPLATE_NAME, [
            EventDispatcherInterface::class => $this->globalDispatcher,
            \Psr\EventDispatcher\EventDispatcherInterface::class => $this->dispatcher,
        ]));
    }
}
