<?php

declare(strict_types=1);

use Auryn\Injector;
use ItalyStrap\Asset\Module as AssetModule;
use ItalyStrap\Config\ConfigFactory;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Config\ConfigProviderExtension;
use ItalyStrap\Config\ConfigThemeModsProvider;
use ItalyStrap\Customizer\Module as CustomizerModule;
use ItalyStrap\Empress\PhpFileProvider;
use ItalyStrap\Empress\ProvidersCacheInterface;
use ItalyStrap\Empress\ProvidersCollection;
use ItalyStrap\Event\Module as EventModule;
use ItalyStrap\Experimental\ExperimentalThemeFileFinderFactory;
use ItalyStrap\Experimental\Module as ExperimentalModule;
use ItalyStrap\Navigation\Module as NavigationModule;
use ItalyStrap\Theme\Module as ThemeModule;
use ItalyStrap\UI\Module as UIModule;

return static function (Injector $injector): ConfigInterface {
    $config =  (new ConfigFactory())->make();
    $collection = new ProvidersCollection(
        $injector,
        $config,
        null,
        [
            // First we load Modules from packages
            EventModule::class,

            // Then we load Modules from this theme
            ThemeModule::class,
            AssetModule::class,
            CustomizerModule::class,
            ExperimentalModule::class,
            NavigationModule::class,
            UIModule::class,
            new PhpFileProvider(
                '/config/autoload/{{,*.}global,{,*.}local}.php',
                $injector->execute(ExperimentalThemeFileFinderFactory::class)
            ),
            // ProvidersCacheInterface::CACHE_PATH => get_template_directory() . '/config/cache/config-cache.php',
            fn(): array => [
            // ProvidersCacheInterface::CACHE_PATH => get_template_directory() . '/config/cache/config-cache.php',
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

    return $config;
};
