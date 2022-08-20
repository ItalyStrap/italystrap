<?php
declare(strict_types=1);

use ItalyStrap\Config\ConfigCustomHeaderProvider;
use ItalyStrap\Config\ConfigNavigationProvider;
use ItalyStrap\Config\ConfigPostTypeSupportProvider;
use ItalyStrap\Config\ConfigSidebarProvider;
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
		ConfigCustomHeaderProvider::class,
		ConfigSiteLogoProvider::class,
		ConfigColorSectionProvider::class,
		ConfigMiscProvider::class,
		ConfigNavigationProvider::class,
		ConfigColophonProvider::class,

		ConfigNotFoundProvider::class,
		ConfigPostThumbnailProvider::class,
		ConfigThemeSupportProvider::class,
		ConfigPostTypeSupportProvider::class,
		ConfigSidebarProvider::class,

		/** This must run after all */
		ConfigThemeModsProvider::class,
	],
];
