<?php

declare(strict_types=1);

namespace ItalyStrap\Components\Footer;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Config\ConfigColophonProvider;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\GlobalDispatcherInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\View\ViewInterface;

class Colophon implements ComponentInterface, SubscriberInterface
{
    public const EVENT_PRIORITY = 20;
    public const CONTENT = 'content';

    public const TEMPLATE_NAME = 'footer/colophon';

    private ConfigInterface $config;
    private ViewInterface $view;
    private GlobalDispatcherInterface $globalDispatcher;

    public function getSubscribedEvents(): iterable
    {
        $event_name = (string)$this->config->get(
            ConfigColophonProvider::COLOPHON_ACTION,
            \ItalyStrap\Components\Footer\Events\Footer::class
        );
        $event_priority = (int)$this->config->get(ConfigColophonProvider::COLOPHON_PRIORITY, self::EVENT_PRIORITY);
        yield $event_name   => [
            static::CALLBACK    => $this,
            static::PRIORITY    => $event_priority,
        ];
    }

    public function __construct(
        ConfigInterface $config,
        ViewInterface $view,
        GlobalDispatcherInterface $dispatcher
    ) {
        $this->config = $config;
        $this->view = $view;
        $this->globalDispatcher = $dispatcher;
    }

    public function shouldDisplay(): bool
    {
        return true;
    }

    public function __invoke(\ItalyStrap\Components\Footer\Events\Footer $event): void
    {
        $content = (string)$this->config->get(ConfigColophonProvider::COLOPHON, '');

        if (empty($content)) {
            return;
        }

        $event->appendContent(\do_blocks($this->view->render(self::TEMPLATE_NAME, [
            self::CONTENT => $this->globalDispatcher->filter('italystrap_colophon_output', $content),
        ])));
    }
}
