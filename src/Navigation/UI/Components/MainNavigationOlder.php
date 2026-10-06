<?php

declare(strict_types=1);

namespace ItalyStrap\Navigation\UI\Components;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Header\Events\Content;
use ItalyStrap\View\ViewInterface;

class MainNavigationOlder implements ComponentInterface, SubscriberInterface
{
    public const EVENT_PRIORITY = 10;

    public const TEMPLATE_NAME = 'navigation/navbar';

    public function getSubscribedEvents(): iterable
    {
        yield Content::class => [
            SubscriberInterface::CALLBACK => $this,
            SubscriberInterface::PRIORITY => self::EVENT_PRIORITY,
        ];
    }

    private ConfigInterface $config;
    private ViewInterface $view;
    private \ItalyStrap\Navigation\UI\Components\Navbar $navbar;
    private NavMenuPrimary $navMenuPrimary;
    private NavMenuSecondary $navMenuSecondary;

    public function __construct(
        ConfigInterface $config,
        ViewInterface $view,
        \ItalyStrap\Navigation\UI\Components\Navbar $navbar,
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

    public function __invoke(Content $event): void
    {
        $event->appendContent(\do_blocks($this->view->render(self::TEMPLATE_NAME, [
            'mods'      => $this->config,
            Navbar::class   => $this->navbar,
            NavMenuPrimary::class => $this->navMenuPrimary,
            NavMenuSecondary::class => $this->navMenuSecondary,
        ])));
    }
}
