<?php

declare(strict_types=1);

namespace ItalyStrap\Experimental;

use Auryn\Injector;
use ItalyStrap\Finder\FinderFactory;
use ItalyStrap\Finder\FinderInterface;

use function array_unique;

final class ExperimentalThemeFileFinderFactory
{
    public function __invoke(Injector $injector): FinderInterface
    {
        return (new FinderFactory())->make()
            ->in(array_unique(
                [
                    /**
                     * To remember:
                     * This is the correct hierarchy to load and override
                     * the parent with child config.
                     */
                    get_template_directory(),
                    get_stylesheet_directory(),
                ]
            ));
    }
}
