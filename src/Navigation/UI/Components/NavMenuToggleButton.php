<?php

declare(strict_types=1);

namespace ItalyStrap\Navigation\UI\Components;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\GlobalDispatcherInterface as EventDispatcherInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Navigation\UI\Components\Events\NavMenuHeaderContent;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\View\ViewInterface;

class NavMenuToggleButton implements ComponentInterface, SubscriberInterface
{
    // Before the logo, title and tagline, which listen to the same event at priority 10.
    public const EVENT_PRIORITY = 5;

    public function getSubscribedEvents(): iterable
    {
        yield NavMenuHeaderContent::class => [
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
        return true;
    }

    public function __invoke(NavMenuHeaderContent $event): void
    {
        $event->appendContent('<button
				class="navbar-toggler navbar-toggle"
				type="button"
				data-toggle="collapse"
				data-target="#italystrap-menu-440383729"
				aria-controls="italystrap-menu-440383729"
				aria-expanded="false"
				aria-label="Toggle navigation">
				<!-- <span class="navbar-toggler-icon">&nbsp</span>-->
			</button>');
    }
}
