<?php
declare(strict_types=1);

use ItalyStrap\Config\ConfigColophonProvider;
use ItalyStrap\Config\ConfigColorSectionProvider;
use ItalyStrap\Config\ConfigMiscProvider;
use ItalyStrap\Config\ConfigProviderExtension;
use ItalyStrap\Config\ConfigThemeModsProvider;
use ItalyStrap\Config\ConfigThemeProvider;
use ItalyStrap\Empress\AurynConfig;

return [

	AurynConfig::DEFINITIONS => [
		ConfigThemeModsProvider::class => [
			'+theme_mods' => static function () {
				return (array) \get_theme_mods();
			},
		],
	],

	ConfigProviderExtension::class => [
		ConfigThemeProvider::class,
		ConfigColorSectionProvider::class,
		ConfigMiscProvider::class,
		ConfigColophonProvider::class,


		/** This must run after all */
		ConfigThemeModsProvider::class,
	],
];