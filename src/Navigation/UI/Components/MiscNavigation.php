<?php

declare(strict_types=1);

namespace ItalyStrap\Navigation\UI\Components;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\GlobalDispatcherInterface as EventDispatcherInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Header\Events\Content;
use ItalyStrap\View\ViewInterface;

class MiscNavigation implements ComponentInterface, SubscriberInterface
{
    // Before the main navigation, which listens to the same event at priority 10.
    public const EVENT_PRIORITY = 5;

    public const TEMPLATE_NAME = 'navigation/navbar-top';

    public function getSubscribedEvents(): iterable
    {
        yield Content::class => [
            SubscriberInterface::CALLBACK => $this,
            SubscriberInterface::PRIORITY => self::EVENT_PRIORITY,
        ];
    }

    private ConfigInterface $config;
    private ViewInterface $view;
    private EventDispatcherInterface $dispatcher;

    public function __construct(
        ConfigInterface $config,
        ViewInterface $view,
        EventDispatcherInterface $dispatcher
    ) {
        $this->config = $config;
        $this->view = $view;
        $this->dispatcher = $dispatcher;
    }

    public function shouldDisplay(): bool
    {
        return \has_nav_menu('info-menu')
            && \has_nav_menu('social-menu');
    }

    public function __invoke(Content $event): void
    {
        $event->appendContent(\do_blocks($this->view->render(self::TEMPLATE_NAME, [
            EventDispatcherInterface::class => $this->dispatcher,
        ])));
    }
}
