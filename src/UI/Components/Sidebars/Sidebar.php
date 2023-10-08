<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Components\Sidebars;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Theme\Infrastructure\Config\ConfigSidebarProvider;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Main\Events\ContentAfter;
use ItalyStrap\View\ViewInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class Sidebar implements ComponentInterface, SubscriberInterface
{
    public function getSubscribedEvents(): iterable
    {
        yield ContentAfter::class   => $this;
    }

    public const TEMPLATE_NAME = 'sidebars/sidebar';
    public const INDEX = 'index';

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
        return ('full_width' !== $this->config->get('site_layout'))
            && \is_active_sidebar(ConfigSidebarProvider::SIDEBAR_PRIMARY);
    }

    public function __invoke(ContentAfter $event): void
    {
        $event->appendContent($this->view->render(self::TEMPLATE_NAME, [
            EventDispatcherInterface::class => $this->dispatcher,
            self::INDEX => ConfigSidebarProvider::SIDEBAR_PRIMARY,
        ]));
    }
}
