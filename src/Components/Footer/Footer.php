<?php

declare(strict_types=1);

namespace ItalyStrap\Components\Footer;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Components\SubscribedEventsAware;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\EventDispatcherInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\View\ViewInterface;

class Footer implements ComponentInterface, SubscriberInterface
{
    use SubscribedEventsAware;

    public const EVENT_NAME = 'italystrap_after_main';
    public const EVENT_PRIORITY = 10;

    public const TEMPLATE_NAME = 'footer/footer';

    private ConfigInterface $config;
    private ViewInterface $view;
    private EventDispatcherInterface $globalDispatcher;

    private \Psr\EventDispatcher\EventDispatcherInterface $dispatcher;

    public function __construct(
        ConfigInterface $config,
        ViewInterface $view,
        EventDispatcherInterface $globalDispatcher,
        \Psr\EventDispatcher\EventDispatcherInterface $dispatcher
    ) {
        $this->config = $config;
        $this->view = $view;
        $this->globalDispatcher = $globalDispatcher;
        $this->dispatcher = $dispatcher;
    }

    public function shouldDisplay(): bool
    {
        return true;
    }

    public function display(): void
    {
        echo $this->view->render(self::TEMPLATE_NAME, [
            EventDispatcherInterface::class => $this->globalDispatcher,
            \Psr\EventDispatcher\EventDispatcherInterface::class => $this->dispatcher,
        ]);
    }
}
