<?php

declare(strict_types=1);

use ItalyStrap\Config\ConfigFactory;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Empress\Injector;
use ItalyStrap\Empress\PhpFileProvider;
use ItalyStrap\Empress\ProvidersCollection;
use ItalyStrap\Finder\FinderInterface;

return static function (Injector $injector, FinderInterface $finder): ConfigInterface {
    return (new ProvidersCollection(
        $injector,
        ConfigFactory::make(),
        [
            \ItalyStrap\Components\Module::class,
            new PhpFileProvider(
                '/config/autoload/{{,*.}global,{,*.}local}.php',
                $finder
            )
        ],
        null
    ))->collection();
};
