<?php

declare(strict_types=1);

namespace ItalyStrap\Experimental;

use Auryn\Injector;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Finder\FinderFactory;
use ItalyStrap\Finder\FinderInterface;
use ItalyStrap\Theme\Infrastructure\Config\ConfigThemeProvider;

class ExperimentalViewFileFinderFactory
{
    public function __invoke(string $named_param, Injector $injector): FinderInterface
    {

        $config = $injector->make(ConfigInterface::class);
        $stylesheet_dir = $config->get(ConfigThemeProvider::STYLESHEET_DIR);
        $template_dir = $config->get(ConfigThemeProvider::TEMPLATE_DIR);
        $view_dir = $config->get(ConfigThemeProvider::VIEW_DIR);
        $finder = (new FinderFactory())->make()
            ->in([
                $stylesheet_dir . '/' . $view_dir,
                $template_dir . '/' . $view_dir,
            ]);
        return $finder;
    }
}
