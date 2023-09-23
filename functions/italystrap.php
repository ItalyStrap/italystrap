<?php

declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\Components\Main\Events\Index;
use Psr\EventDispatcher\EventDispatcherInterface;
use function ItalyStrap\Factory\injector;

/**
 * Function for loading the template.
 *
 * @param array $args
 */
function italystrap(...$args): void
{
    echo injector()
        ->make(EventDispatcherInterface::class)
        ->dispatch(new Index());

    /**
     * @TODO Are they good hooks?
     */
//    do_action('italystrap_build', $args);
//    do_action('italystrap', $args);
}
