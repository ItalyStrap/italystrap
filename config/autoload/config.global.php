<?php
declare(strict_types=1);

use ItalyStrap\Config\ConfigSiteLogoProvider;
use ItalyStrap\Config\ConfigColophonProvider;
use ItalyStrap\Config\ConfigColorSectionProvider;
use ItalyStrap\Config\ConfigMiscProvider;
use ItalyStrap\Config\ConfigNotFoundProvider;
use ItalyStrap\Config\ConfigPostThumbnailProvider;
use ItalyStrap\Config\ConfigProviderExtension;
use ItalyStrap\Config\ConfigThemeModsProvider;
use ItalyStrap\Config\ConfigThemeProvider;
use ItalyStrap\Config\ConfigThemeSupportProvider;
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
		ConfigSiteLogoProvider::class,
		ConfigColorSectionProvider::class,
		ConfigMiscProvider::class,
		ConfigColophonProvider::class,

		ConfigNotFoundProvider::class,
		ConfigPostThumbnailProvider::class,
		ConfigThemeSupportProvider::class,

		/** This must run after all */
		ConfigThemeModsProvider::class,
	],
];