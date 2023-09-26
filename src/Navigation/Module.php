<?php

declare(strict_types=1);

namespace ItalyStrap\Navigation;

use ItalyStrap\Components\ComponentSubscriberExtension;
use ItalyStrap\Config\ConfigProviderExtension;
use ItalyStrap\Empress\AurynConfig;
use ItalyStrap\Empress\Injector;
use ItalyStrap\Event\SubscribersConfigExtension;
use ItalyStrap\Navigation\Admin\ItemCustomFieldsSubscriber;
use ItalyStrap\Navigation\Application\NavMenusSubscriber;
use ItalyStrap\Navigation\Domain\NavMenu;
use ItalyStrap\Navigation\Domain\NavMenuInterface;
use ItalyStrap\Navigation\Domain\NavMenuLocation;
use ItalyStrap\Navigation\Domain\NavMenuLocationInterface;
use ItalyStrap\Navigation\Infrastructure\BootstrapNavMenu;
use ItalyStrap\Navigation\Infrastructure\Config\ConfigNavigationProvider;
use ItalyStrap\Navigation\Infrastructure\NavMenuFallback;
use ItalyStrap\Navigation\UI\Components\Breadcrumbs;
use ItalyStrap\Navigation\UI\Components\MainNavigationOlder;
use ItalyStrap\Navigation\UI\Components\MiscNavigation;
use ItalyStrap\Navigation\UI\Components\Navbar;
use ItalyStrap\Navigation\UI\Components\NavMenuHeader;
use ItalyStrap\Navigation\UI\Components\NavMenuPrimary;
use ItalyStrap\Navigation\UI\Components\NavMenuSecondary;
use ItalyStrap\Navigation\UI\Components\NavMenuToggleButton;
use ItalyStrap\Navigation\UI\Components\Pager;
use ItalyStrap\Navigation\UI\Components\Pagination;
use Walker_Nav_Menu;

class Module
{
    public function __invoke(): iterable
    {
        return [
            AurynConfig::SHARING => [
            ],
            AurynConfig::ALIASES => [
                NavMenuLocationInterface::class     => NavMenuLocation::class,
                NavMenuInterface::class             => NavMenu::class,
                Walker_Nav_Menu::class              => BootstrapNavMenu::class,
            ],

            AurynConfig::DEFINITIONS => [

                Navbar::class    => [
                    ':fallback_cb' => [ BootstrapNavMenu::class, 'fallback' ],
                ],

                NavMenuPrimary::class => [
                    '+fallback' => static function (string $named_param, Injector $injector): callable {

                        return $injector->make(NavMenuFallback::class);
                    },
                ],
            ],

            ConfigProviderExtension::class => [
                ConfigNavigationProvider::class,
            ],

            SubscribersConfigExtension::SUBSCRIBERS => [
                ItemCustomFieldsSubscriber::class,
                NavMenusSubscriber::class,
            ],
            ComponentSubscriberExtension::class => [
                Breadcrumbs::class,

                NavMenuToggleButton::class,
                NavMenuHeader::class,
                NavMenuPrimary::class,
                NavMenuSecondary::class,
                MainNavigationOlder::class,
                //     MainNavigation::class,

                MiscNavigation::class,

//                Navbar::class,
                NavMenuPrimary::class,

                Pager::class,
                Pagination::class,
            ],
        ];
    }
}
