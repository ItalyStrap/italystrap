<?php
declare(strict_types=1);

use ItalyStrap\Config\ConfigFactory;
use ItalyStrap\Experimental\PhpFileProvider;
use ItalyStrap\Finder\FinderInterface;

return static function ( FinderInterface $finder ) {
    return ConfigFactory::make()->merge(
        ...(new PhpFileProvider(
            '/config/autoload/{{,*.}global,{,*.}local}.php',
                $finder
        ))()
    );
};
