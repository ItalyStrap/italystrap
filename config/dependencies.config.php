<?php

declare(strict_types=1);

use ItalyStrap\Components\Module;
use ItalyStrap\Config\ConfigFactory;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Empress\Injector;
use ItalyStrap\Empress\PhpFileProvider;
use ItalyStrap\Empress\ProvidersCacheInterface;
use ItalyStrap\Empress\ProvidersCollection;
use ItalyStrap\Experimental\ExperimentalThemeFileFinderFactory;

return static function (Injector $injector): ConfigInterface {
//    (string)$injector->execute(ExperimentalThemeFileFinderFactory::class)->firstFile('config/cache/config-cache')
    $collection = new ProvidersCollection(
        $injector,
        ConfigFactory::make(
//            [
//                ProvidersCacheInterface::CACHE_PATH => \get_template_directory() . '/config/cache/config-cache.php',
//            ]
        ),
        [
            // First we load Modules from packages
            \ItalyStrap\Event\Module::class,

            // Then we load Modules from this theme
            \ItalyStrap\Theme\Module::class,
            \ItalyStrap\Asset\Module::class,
            \ItalyStrap\Navigation\Module::class,
            \ItalyStrap\Components\Module::class,
            new PhpFileProvider(
                '/config/autoload/{{,*.}global,{,*.}local}.php',
                $injector->execute(ExperimentalThemeFileFinderFactory::class)
            ),
            function (): array {
                return [
                    ProvidersCacheInterface::ENABLE_CACHE => true,
                ];
            },
        ],
    );

    $collection->build();

    return $collection->collection();
};
