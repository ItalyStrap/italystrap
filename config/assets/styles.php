<?php

declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\Asset\Asset;
use ItalyStrap\Asset\ConfigBuilder;

return [
    [
        Asset::HANDLE            => CURRENT_TEMPLATE_SLUG,
        ConfigBuilder::FILE_NAME => 'build/css/index.css',
    ],
];
