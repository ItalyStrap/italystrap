<?php

declare(strict_types=1);

use ItalyStrap\Asset\Module as AssetModule;
use ItalyStrap\Config\ConfigFactory;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Config\ConfigProviderExtension;
use ItalyStrap\Config\ConfigThemeModsProvider;
use ItalyStrap\Empress\Injector;
use ItalyStrap\Empress\PhpFileProvider;
use ItalyStrap\Empress\ProvidersCacheInterface;
use ItalyStrap\Empress\ProvidersCollection;
use ItalyStrap\Event\Module as EventModule;
use ItalyStrap\Experimental\ExperimentalThemeFileFinderFactory;
use ItalyStrap\Navigation\Module as NavigationModule;
use ItalyStrap\Theme\Module as ThemeModule;

return static function (Injector $injector): ConfigInterface {
    $collection = new ProvidersCollection(
        $injector,
        ConfigFactory::make(),
        [
            // First we load Modules from packages
            EventModule::class,

            // Then we load Modules from this theme
            ThemeModule::class,
            AssetModule::class,
            NavigationModule::class,
            \ItalyStrap\UI\Module::class,
            new PhpFileProvider(
                '/config/autoload/{{,*.}global,{,*.}local}.php',
                $injector->execute(ExperimentalThemeFileFinderFactory::class)
            ),
            //                    ProvidersCacheInterface::CACHE_PATH => get_template_directory() . '/config/cache/config-cache.php',
            fn(): array => [
        //                    ProvidersCacheInterface::CACHE_PATH => get_template_directory() . '/config/cache/config-cache.php',
                ProvidersCacheInterface::ENABLE_CACHE => true,
            ],
            /** This must run after all */
            fn(): array => [
                ConfigProviderExtension::class => [
                    /** This must run after all */
                    ConfigThemeModsProvider::class,
                ],
            ],
        ],
    );

    $collection->build();

    return $collection->collection();
};
