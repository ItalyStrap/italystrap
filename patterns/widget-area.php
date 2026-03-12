<?php

/**
 * Title: Widget Area
 * Slug: italystrap/widget-area
 * Categories: footer
 */

declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\Theme\Infrastructure\Config\ConfigSidebarProvider;
use ItalyStrap\UI\Components\Footer\FooterWidgetArea;
use ItalyStrap\UI\Infrastructure\ViewBlockInterface;
use ItalyStrap\View\ViewInterface;

use function ItalyStrap\Factory\injector;

$injector = injector();

$view = $injector->make(ViewInterface::class);
//$view = $injector->make(ViewBlockInterface::class);

echo $view->render(FooterWidgetArea::TEMPLATE_NAME, [
    FooterWidgetArea::REGISTERED_WIDGET_AREAS => ConfigSidebarProvider::FOOTERS,
]);
