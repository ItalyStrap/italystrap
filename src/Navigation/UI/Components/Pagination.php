<?php

declare(strict_types=1);

namespace ItalyStrap\Navigation\UI\Components;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Components\SubscribedEventsAware;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\View\ViewInterface;

class Pagination implements SubscriberInterface, ComponentInterface
{
    use SubscribedEventsAware;

    public const EVENT_NAME = 'italystrap_after_loop';
    public const EVENT_PRIORITY = 10;

    public const TEMPLATE_NAME = 'navigation/pagination';

    private ConfigInterface $config;
    private ViewInterface $view;

    public function __construct(ConfigInterface $config, ViewInterface $view)
    {
        $this->config = $config;
        $this->view = $view;
    }

    public function shouldDisplay(): bool
    {
        return ! \is_404();
    }

    public function display(): void
    {
        echo \do_blocks($this->view->render(self::TEMPLATE_NAME, []));
    }
}
