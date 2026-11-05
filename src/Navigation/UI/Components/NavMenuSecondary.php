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

class NavMenuSecondary implements ComponentInterface, \ItalyStrap\Event\SubscriberInterface
{
    public const EVENT_PRIORITY = 10;

    public function getSubscribedEvents(): iterable
    {
        yield NavMenuContent::class => [
            \ItalyStrap\Event\SubscriberInterface::CALLBACK => $this,
            \ItalyStrap\Event\SubscriberInterface::PRIORITY => self::EVENT_PRIORITY,
        ];
    }

    public function __construct(
        private ConfigInterface $config,
        private ViewInterface $view,
        private NavMenuInterface $menu,
        private NavMenuLocationInterface $location,
    ) {
    }

    public function shouldDisplay(): bool
    {
        return $this->location->has(self::class);
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
            NavMenu::MENU_CLASS_NAME => 'nav navbar-nav navbar-right',
            NavMenu::MENU_ID => 'secondary-menu',
            NavMenu::FALLBACK_CB => false,
            NavMenu::THEME_LOCATION => self::class,
        ]);
    }
}
