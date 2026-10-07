<?php

declare(strict_types=1);

namespace ItalyStrap\Navigation\UI\Components;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Navigation\Domain\NavMenu;
use ItalyStrap\Navigation\Domain\NavMenuInterface;
use ItalyStrap\Navigation\Domain\NavMenuLocationInterface;
use ItalyStrap\Navigation\UI\Components\Events\NavMenuContent;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\View\ViewInterface;

class NavMenuPrimary implements ComponentInterface, \ItalyStrap\Event\SubscriberInterface
{
    public const EVENT_PRIORITY = 10;

    public function getSubscribedEvents(): iterable
    {
        yield NavMenuContent::class => [
            \ItalyStrap\Event\SubscriberInterface::CALLBACK => $this,
            \ItalyStrap\Event\SubscriberInterface::PRIORITY => self::EVENT_PRIORITY,
        ];
    }

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
        ?callable $fallback = null
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

    public function __invoke(NavMenuContent $event): void
    {
        $event->appendContent($this->render());
    }

    /**
     * Also used by the navbar view, which prints the menu in its own markup.
     */
    public function render(): string
    {
        return $this->menu->render([
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
