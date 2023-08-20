<?php

declare(strict_types=1);

use ItalyStrap\Config\ConfigFactory;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Empress\Injector;
use ItalyStrap\Empress\PhpFileProvider;
use ItalyStrap\Empress\ProvidersCollection;
use ItalyStrap\Finder\FinderInterface;
use ItalyStrap\Theme\ExperimentalThemeFileFinderFactory;

return static function (Injector $injector, FinderInterface $finder): ConfigInterface {
    return (new ProvidersCollection(
        $injector,
        $injector->make(ConfigInterface::class),
        [
            \ItalyStrap\Components\Module::class,
            new PhpFileProvider(
                '/config/autoload/{{,*.}global,{,*.}local}.php',
//                $finder
                $injector->execute(ExperimentalThemeFileFinderFactory::class)
            )
        ],
        null
    ))->collection();
};
