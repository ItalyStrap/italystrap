<?php
declare(strict_types=1);

use ItalyStrap\Customizer\BetaFields;
use ItalyStrap\Customizer\BreadcrumsFields;
use ItalyStrap\Customizer\ColophonFields;
use ItalyStrap\Customizer\ColorFields;
use ItalyStrap\Customizer\CustomCssFields;
use ItalyStrap\Customizer\CustomHeaderFields;
use ItalyStrap\Customizer\CustomizerProviderExtension;
use ItalyStrap\Customizer\DefaultPostThumbnailSubscriber;
use ItalyStrap\Customizer\LayoutFields;
use ItalyStrap\Customizer\NavbarFields;
use ItalyStrap\Customizer\NotFoundFields;
use ItalyStrap\Customizer\PanelFields;
use ItalyStrap\Customizer\PostContentTemplateFields;
use ItalyStrap\Customizer\PostThumbnailFields;
use ItalyStrap\Customizer\SiteIdentityFields;
use ItalyStrap\Customizer\SiteLogoFields;
use ItalyStrap\Customizer\ThemeSubmenuPageSubscriber;
use ItalyStrap\Event\SubscribersConfigExtension;
use function ItalyStrap\Bools\experimental_is_block_theme;

if ( experimental_is_block_theme() ) {
	return [];
}

return [
	CustomizerProviderExtension::class => [
		SiteLogoFields::class,
		BreadcrumsFields::class,
		CustomCssFields::class,
		SiteIdentityFields::class,
		PanelFields::class,
		BetaFields::class,
		ColorFields::class,
		ColophonFields::class,
		CustomHeaderFields::class,
		LayoutFields::class,
		NavbarFields::class,
		PostThumbnailFields::class,
		PostContentTemplateFields::class,
		NotFoundFields::class,
	],
	SubscribersConfigExtension::SUBSCRIBERS => [
		DefaultPostThumbnailSubscriber::class,
		ThemeSubmenuPageSubscriber::class,
	],
];
