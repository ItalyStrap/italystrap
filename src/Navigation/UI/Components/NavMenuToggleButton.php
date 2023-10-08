<?php

declare(strict_types=1);

namespace ItalyStrap\Navigation\UI\Components;

use ItalyStrap\Components\SubscribedEventsAware;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\EventDispatcherInterface;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\View\ViewInterface;

class NavMenuToggleButton implements ComponentInterface, \ItalyStrap\Event\SubscriberInterface
{
    use SubscribedEventsAware;

    public const EVENT_NAME = 'italystrap_navmenu_header';
    public const EVENT_PRIORITY = 10;

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

    public function display(): void
    {
        echo '<button
				class="navbar-toggler navbar-toggle"
				type="button"
				data-toggle="collapse"
				data-target="#italystrap-menu-440383729"
				aria-controls="italystrap-menu-440383729"
				aria-expanded="false"
				aria-label="Toggle navigation">
				<!-- <span class="navbar-toggler-icon">&nbsp</span>-->
			</button>';
    }
}
