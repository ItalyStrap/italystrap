<?php
declare(strict_types=1);

use ItalyStrap\Experimental\DependenciesAggregator;
use ItalyStrap\Experimental\PhpFileProvider;
use ItalyStrap\Finder\FinderFactory;

$dependencies_collection = new DependenciesAggregator([
	new PhpFileProvider(
		'/config/autoload/{{,*.}global,{,*.}local}.php',
		( new FinderFactory() )->make()
			->in(
				\array_unique(
					[
						/**
						 * To remember:
						 * This is the correct hierarchy to load and override
						 * the parent with child config.
						 * @see get_config_file_content
						 */
						get_template_directory(),
						get_stylesheet_directory(),
					]
				)
			)
	)
]);

return $dependencies_collection;
