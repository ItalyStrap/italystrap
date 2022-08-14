<?php
declare(strict_types=1);

use ItalyStrap\Customizer\CustomizerAssetsSubscriber;
use ItalyStrap\Event\SubscribersConfigExtension;
use function ItalyStrap\Bools\experimental_is_block_theme;

if ( experimental_is_block_theme() ) {
	return [];
}

return [
	\ItalyStrap\Customizer\CustomizerProviderExtension::class => [
		\ItalyStrap\Customizer\SiteLogoFields::class,
		\ItalyStrap\Customizer\BreadcrumsFields::class,
		\ItalyStrap\Customizer\CustomCssFields::class,
		\ItalyStrap\Customizer\SiteIdentityFields::class,
		\ItalyStrap\Customizer\PanelFields::class,
		\ItalyStrap\Customizer\BetaFields::class,
		\ItalyStrap\Customizer\ColorFields::class,
		\ItalyStrap\Customizer\ColophonFields::class,
		\ItalyStrap\Customizer\CustomHeaderFields::class,
		\ItalyStrap\Customizer\LayoutFields::class,
		\ItalyStrap\Customizer\NavbarFields::class,
		\ItalyStrap\Customizer\PostThumbnailFields::class,
		\ItalyStrap\Customizer\PostContentTemplateFields::class,
		\ItalyStrap\Customizer\NotFoundFields::class,
	],
	SubscribersConfigExtension::SUBSCRIBERS => [
		CustomizerAssetsSubscriber::class,
		\ItalyStrap\Customizer\DefaultPostThumbnailSubscriber::class,
		\ItalyStrap\Customizer\ThemeSubmenuPageSubscriber::class,
	],
];
