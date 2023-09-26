<?php

declare(strict_types=1);

namespace ItalyStrap\Navigation\UI\Components;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Components\SubscribedEventsAware;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\EventDispatcherInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\View\ViewInterface;

class MiscNavigation implements ComponentInterface, SubscriberInterface
{
    use SubscribedEventsAware;

    public const EVENT_NAME = 'italystrap_before_header';
    public const EVENT_PRIORITY = 10;

    public const TEMPLATE_NAME = 'navigation/navbar-top';

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

    public function display(): void
    {
        echo \do_blocks($this->view->render(self::TEMPLATE_NAME, [
            EventDispatcherInterface::class => $this->dispatcher,
        ]));
    }
}
