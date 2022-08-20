<?php
declare(strict_types=1);

namespace ItalyStrap\Theme;

use ItalyStrap\Finder\FinderFactory;
use ItalyStrap\Finder\FinderInterface;

final class ExperimentalThemeFileFinderFactory {

	public function __invoke( \Auryn\Injector $injector ) {
//        $finder =  $injector->make( FinderInterface::class );
		$finder =  (new FinderFactory())->make()
		->in(
			\array_unique(
				[
					/**
					 * To remember:
					 * This is the correct hierarchy to load and override
					 * the parent with child config.
					 */
					get_template_directory(),
					get_stylesheet_directory(),
				]
			)
		);
		return $finder;
	}
}
