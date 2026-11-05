<?php

/**
 * The styles of the front end, a child theme replaces this file with its own config/assets/styles.php.
 *
 * @see \ItalyStrap\Assets\Application\ConfigAssetsSubscriber
 */

declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\Asset\Handle;
use ItalyStrap\Asset\Style;
use ItalyStrap\Assets\Infrastructure\ThemeFile;

$style = new ThemeFile('build/css/index.css');

return [
    new Style(
        handle: new Handle(CURRENT_TEMPLATE_SLUG),
        source: $style->url(),
        dependencies: $style->dependencies(),
        version: $style->version(),
    ),
];
