<?php

declare(strict_types=1);

namespace ItalyStrap\Components\Navigations;

use ItalyStrap\Event\EventDispatcherInterface;

use function wp_link_pages;

/**
 * Class description
 * @deprecated
 */
class LinkPages
{
    private \ItalyStrap\Event\EventDispatcherInterface $dispatcher;

    /**
     * LinkPages constructor.
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
    /**
     * Render the output of the controller.
     */
    public function render(): string
    {

        /**
         * Arguments for wp_link_pages
         *
         * @link https://developer.wordpress.org/reference/functions/wp_link_pages/
         * @var array
         */
        $args = [
            'echo'      => false,
        ];

        $args = $this->dispatcher->filter('italystrap_wp_link_pages_args', $args);

        return wp_link_pages($args);
    }
}
