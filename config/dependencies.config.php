<?php

declare(strict_types=1);

use ItalyStrap\Config\ConfigFactory;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Empress\Injector;
use ItalyStrap\Empress\PhpFileProvider;
use ItalyStrap\Empress\ProvidersCollection;
use ItalyStrap\Theme\ExperimentalThemeFileFinderFactory;

return static function (Injector $injector): ConfigInterface {
    $collection = new ProvidersCollection(
        $injector,
        ConfigFactory::make(),
        [
            \ItalyStrap\Event\Module::class,
            \ItalyStrap\Components\Module::class,
            new PhpFileProvider(
                '/config/autoload/{{,*.}global,{,*.}local}.php',
                $injector->execute(ExperimentalThemeFileFinderFactory::class)
            ),
//            function (): array {
//                return [
//                    'config_cache_enabled' => true,
//                ];
//            },
        ],
//        (string)$injector->execute(ExperimentalThemeFileFinderFactory::class)->firstFile('config/cache/config-cache')
    );
    $collection->build();

    return $collection->collection();
};
