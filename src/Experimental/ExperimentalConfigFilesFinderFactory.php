<?php

declare(strict_types=1);

namespace ItalyStrap\Experimental;

use ItalyStrap\Finder\FinderFactory;
use ItalyStrap\Finder\FinderInterface;

use function get_stylesheet_directory;
use function get_template_directory;

class ExperimentalConfigFilesFinderFactory
{
    /**
     * This function return a Finder object
     * with config dirs with this order:
     * 0 => Parent
     * 1 => Child
     * @return FinderInterface
     */
    public function __invoke(): FinderInterface
    {
        static $experimental_finder = null;

        if (! $experimental_finder) {
            $experimental_finder = ( new FinderFactory() )
                ->make()
                ->in(
                    [
                        /**
                         * To remember:
                         * This is the correct hierarchy to load and override
                         * the parent with child config.
                         */
                        get_template_directory() . '/config/',
                        get_stylesheet_directory() . '/config/',
                    ]
                );
        }

        return $experimental_finder;
    }
}
