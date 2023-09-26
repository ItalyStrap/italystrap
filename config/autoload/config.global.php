<?php

declare(strict_types=1);

use ItalyStrap\Config\ConfigColophonProvider;
use ItalyStrap\Config\ConfigColorSectionProvider;
use ItalyStrap\Config\ConfigCustomHeaderProvider;
use ItalyStrap\Config\ConfigMiscProvider;
use ItalyStrap\Config\ConfigNotFoundProvider;
use ItalyStrap\Config\ConfigProviderExtension;
use ItalyStrap\Config\ConfigSiteLogoProvider;
use ItalyStrap\Config\ConfigThemeModsProvider;
use ItalyStrap\Empress\AurynConfig;

return [

    AurynConfig::DEFINITIONS => [
        ConfigThemeModsProvider::class => [
            '+theme_mods' => static function () {
                return (array) \get_theme_mods();
            },
        ],
    ],

    ConfigProviderExtension::class => [
        ConfigCustomHeaderProvider::class,
        ConfigSiteLogoProvider::class,
        ConfigColorSectionProvider::class,
        ConfigMiscProvider::class,
        ConfigColophonProvider::class,

        ConfigNotFoundProvider::class,

        /** This must run after all */
        ConfigThemeModsProvider::class,
    ],
];
