<?php

declare(strict_types=1);

namespace ItalyStrap;

/**
 * Function for loading the template.
 *
 * @param array $args
 */
function italystrap(...$args): void
{

    /**
     * @TODO Are they good hooks?
     */
    do_action('italystrap_build', $args);
    do_action('italystrap', $args);
}
