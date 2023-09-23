<?php

declare(strict_types=1);

namespace ItalyStrap\Components\Navigation;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Components\Navigations;
use ItalyStrap\Components\Navigations\Navbar;
use ItalyStrap\Components\SubscribedEventsAware;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\View\ViewInterface;

class MainNavigationOlder implements ComponentInterface, SubscriberInterface
{
    use SubscribedEventsAware;

    public const EVENT_NAME = 'italystrap_after_header';
    public const EVENT_PRIORITY = 10;

    private ConfigInterface $config;
    private ViewInterface $view;
    private Navigations\Navbar $navbar;
    private NavMenuPrimary $navMenuPrimary;
    private NavMenuSecondary $navMenuSecondary;

    public function __construct(
        ConfigInterface $config,
        ViewInterface $view,
        Navigations\Navbar $navbar,
        NavMenuPrimary $navMenuPrimary,
        NavMenuSecondary $navMenuSecondary
    ) {
        $this->config = $config;
        $this->view = $view;
        $this->navbar = $navbar;
        $this->navMenuPrimary = $navMenuPrimary;
        $this->navMenuSecondary = $navMenuSecondary;
    }

    public function shouldDisplay(): bool
    {
        return true;
    }

    public function display(): void
    {
        echo \do_blocks($this->view->render('navigation/navbar', [
            'mods'      => $this->config,
            Navbar::class   => $this->navbar,
            NavMenuPrimary::class => $this->navMenuPrimary,
            NavMenuSecondary::class => $this->navMenuSecondary,
        ]));
    }
}
