<?php

declare(strict_types=1);

use Rector\Php81\Rector\Array_\ArrayToFirstClassCallableRector;
use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
    ])
    ->withPhpSets(php82: true)
    ->withSkip([
        // The module definitions are cached with var_export() when WP_DEBUG is off, a closure cannot be exported
        ArrayToFirstClassCallableRector::class => [
            __DIR__ . '/src/*/Module.php',
        ],
    ]);
