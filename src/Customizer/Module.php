<?php

declare(strict_types=1);

namespace ItalyStrap\Customizer;

use ItalyStrap\Customizer\Fields\BetaFields;
use ItalyStrap\Customizer\Fields\BreadcrumsFields;
use ItalyStrap\Customizer\Fields\ColophonFields;
use ItalyStrap\Customizer\Fields\ColorFields;
use ItalyStrap\Customizer\Fields\CustomCssFields;
use ItalyStrap\Customizer\Fields\CustomHeaderFields;
use ItalyStrap\Customizer\Fields\LayoutFields;
use ItalyStrap\Customizer\Fields\NavbarFields;
use ItalyStrap\Customizer\Fields\NotFoundFields;
use ItalyStrap\Customizer\Fields\PanelFields;
use ItalyStrap\Customizer\Fields\PostContentTemplateFields;
use ItalyStrap\Customizer\Fields\PostThumbnailFields;
use ItalyStrap\Customizer\Fields\SiteIdentityFields;
use ItalyStrap\Customizer\Fields\SiteLogoFields;
use ItalyStrap\Event\SubscribersConfigExtension;

use function ItalyStrap\Bools\experimental_is_block_theme;

class Module
{
    public function __invoke(): iterable
    {
        if (experimental_is_block_theme()) {
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
                CustomizerBodyTagAttributesSubscriber::class,
                CustomizerSubmenuPageSubscriber::class,
            ],
        ];
    }
}
