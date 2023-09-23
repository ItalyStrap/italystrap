<?php

declare(strict_types=1);

namespace ItalyStrap\Components\Navigation;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Components\SubscribedEventsAware;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Navigation\NavMenu;
use ItalyStrap\Navigation\NavMenuInterface;
use ItalyStrap\Navigation\NavMenuLocationInterface;
use ItalyStrap\View\ViewInterface;

class NavMenuPrimary implements ComponentInterface, \ItalyStrap\Event\SubscriberInterface
{
    use SubscribedEventsAware;

    public const EVENT_NAME = 'italystrap_navmenu';
    public const EVENT_PRIORITY = 10;

    private ConfigInterface $config;
    private ViewInterface $view;
    private NavMenu $menu;
    private NavMenuLocationInterface $location;

    /**
     * @var callable
     */
    private $fallback;

    public function __construct(
        ConfigInterface $config,
        ViewInterface $view,
        NavMenuInterface $menu,
        NavMenuLocationInterface $location,
        callable $fallback = null
    ) {
        $this->config = $config;
        $this->view = $view;
        $this->menu = $menu;
        $this->location = $location;
        $this->fallback = $fallback;
    }

    public function shouldDisplay(): bool
    {
        return true;
    }

    public function display(): void
    {
        echo $this->menu->render([
            NavMenu::MENU_CLASS_NAME => \sprintf(
                'nav navbar-nav %s',
                $this->config->get('mods.navbar.main_menu_x_align')
            ),
            NavMenu::MENU_ID => 'main-menu',
            NavMenu::FALLBACK_CB => $this->fallback,
            NavMenu::THEME_LOCATION => self::class,
        ]);
    }
}
