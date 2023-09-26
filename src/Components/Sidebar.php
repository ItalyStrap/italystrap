<?php

declare(strict_types=1);

namespace ItalyStrap\Components;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Theme\Infrastructure\Config\ConfigSidebarProvider;
use ItalyStrap\View\ViewInterface;

class Sidebar implements ComponentInterface, SubscriberInterface
{
    use SubscribedEventsAware;

    public const EVENT_NAME = 'italystrap_after_content';
    public const EVENT_PRIORITY = 10;

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
        return 'full_width' !== $this->config->get('site_layout');
    }

    public function display(): void
    {
        echo $this->view->render('sidebar', [
            'index' => ConfigSidebarProvider::SIDEBAR_PRIMARY,
        ]);
    }
}
