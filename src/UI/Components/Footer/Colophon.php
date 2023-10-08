<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Components\Footer;

use ItalyStrap\Config\ConfigColophonProvider;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Footer\Events\Content;
use ItalyStrap\View\ViewInterface;

class Colophon implements ComponentInterface, SubscriberInterface
{
    public function getSubscribedEvents(): iterable
    {
        $event_name = (string)$this->config->get(
            ConfigColophonProvider::COLOPHON_ACTION,
            Content::class
        );
        $event_priority = (int)$this->config->get(ConfigColophonProvider::COLOPHON_PRIORITY, self::EVENT_PRIORITY);
        yield $event_name   => [
            static::CALLBACK    => $this,
            static::PRIORITY    => $event_priority,
        ];
    }

    public const EVENT_PRIORITY = 20;
    public const CONTENT = 'content';

    public const TEMPLATE_NAME = 'footer/colophon';

    private ConfigInterface $config;
    private ViewInterface $view;

    public function __construct(
        ConfigInterface $config,
        ViewInterface $view
    ) {
        $this->config = $config;
        $this->view = $view;
    }

    public function shouldDisplay(): bool
    {
        return true;
    }

    public function __invoke(Content $event): void
    {
        $content = (string)$this->config->get(ConfigColophonProvider::COLOPHON, '');

        if (empty($content)) {
            return;
        }

        $event->appendContent($this->view->render(self::TEMPLATE_NAME, [
            self::CONTENT => $content,
        ]));
    }
}
