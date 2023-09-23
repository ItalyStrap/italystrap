<?php

declare(strict_types=1);

namespace ItalyStrap\Theme;

use ItalyStrap\Components\NavMenuPrimary;
use ItalyStrap\Components\NavMenuSecondary;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Navigation\NavMenuLocation;

final class NavMenusSubscriber implements SubscriberInterface
{
    private ConfigInterface $config;
    private NavMenuLocation $location;

    public function getSubscribedEvents(): iterable
    {
        yield 'init'    => [
            static::CALLBACK    => $this,
        ];
    }

    public function __construct(ConfigInterface $config, NavMenuLocation $location)
    {
        $this->config = $config;
        $this->location = $location;
    }

    public function __invoke()
    {
        $this->location->registerMany($this->config->get(self::class, []));
        $this->updateOlderNavMenu();
    }

    private function updateOlderNavMenu(): void
    {

        $update = 1;

        if ((int)\get_theme_mod('nav_menu_locations_update') < $update) {
            $menu_location = \get_nav_menu_locations();

            $new_keys = [
                'main-menu' => NavMenuPrimary::class,
                'secondary-menu' => NavMenuSecondary::class,
//              'social-menu' => '0',
//              'info-menu' => '0',
//              'footer-menu' => '0',
            ];

            $new_menu_locations = [];
            foreach ($menu_location as $location => $menu_id) {
                if (! \array_key_exists((string)$location, $new_keys)) {
                    continue;
                }

                if ($menu_id === 0) {
                    continue;
                }

                $new_menu_locations[$new_keys[$location]] = $menu_id;
            }

            \set_theme_mod('nav_menu_locations', $new_menu_locations);
            \set_theme_mod('nav_menu_locations_update', $update);
        }
    }
}
