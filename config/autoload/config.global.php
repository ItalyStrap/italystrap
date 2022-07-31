<?php
declare(strict_types=1);

return [

	\ItalyStrap\Config\ConfigProviderExtension::class => [
		\ItalyStrap\Experimental\ConfigThemeProvider::class,
		\ItalyStrap\Experimental\ConfigColorSection::class,
	],
];