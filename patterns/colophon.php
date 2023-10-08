<?php

/**
 * Title: Colophon
 * Slug: italystrap/colophon
 * Categories: footer
 */

declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\Config\ConfigColophonProvider;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\UI\Components\Footer\Colophon;
use ItalyStrap\View\ViewInterface;

use function ItalyStrap\Factory\injector;

$injector = injector();

$view = $injector->make(ViewInterface::class);
$config = $injector->make(ConfigInterface::class);

echo $view->render(Colophon::TEMPLATE_NAME, [
    Colophon::CONTENT   => \wp_strip_all_tags((string)$config->get(ConfigColophonProvider::COLOPHON, '')),
]);
