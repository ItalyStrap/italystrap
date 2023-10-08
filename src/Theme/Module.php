<?php

declare(strict_types=1);

namespace ItalyStrap\Theme;

use ItalyStrap\Config\ConfigProviderExtension;
use ItalyStrap\Empress\AurynConfig;
use ItalyStrap\Event\SubscribersConfigExtension;
use ItalyStrap\Theme\Application\AfterSetupThemeSubscriber;
use ItalyStrap\Theme\Application\ConfigCurrentTemplateSubscriber;
use ItalyStrap\Theme\Application\ConfigWpSubscriber;
use ItalyStrap\Theme\Application\LicenseSubscriber;
use ItalyStrap\Theme\Application\MetaBoxesSubscriber;
use ItalyStrap\Theme\Application\PostTypeSupportSubscriber;
use ItalyStrap\Theme\Application\SidebarsSubscriber;
use ItalyStrap\Theme\Application\SupportSubscriber;
use ItalyStrap\Theme\Application\TextDomainSubscriber;
use ItalyStrap\Theme\Application\ThumbnailsSubscriber;
use ItalyStrap\Theme\Infrastructure\Config\ConfigPostThumbnailProvider;
use ItalyStrap\Theme\Infrastructure\Config\ConfigPostTypeSupportProvider;
use ItalyStrap\Theme\Infrastructure\Config\ConfigSidebarProvider;
use ItalyStrap\Theme\Infrastructure\Config\ConfigThemeProvider;
use ItalyStrap\Theme\Infrastructure\Config\ConfigThemeSupportProvider;
use ItalyStrap\Theme\Infrastructure\ImageSize;
use ItalyStrap\Theme\Infrastructure\ImageSizeInterface;
use ItalyStrap\Theme\Infrastructure\Support;

class Module
{
    public function __invoke(): iterable
    {
        return [
            AurynConfig::SHARING => [
                ImageSizeInterface::class,
                Support::class
            ],
            AurynConfig::ALIASES => [
                ImageSizeInterface::class => ImageSize::class,
            ],
            ConfigProviderExtension::class => [
                ConfigThemeProvider::class,
                ConfigThemeSupportProvider::class,
                ConfigPostTypeSupportProvider::class,
                ConfigSidebarProvider::class,
                ConfigPostThumbnailProvider::class,
            ],
            SubscribersConfigExtension::SUBSCRIBERS => [
                AfterSetupThemeSubscriber::class,
                ConfigCurrentTemplateSubscriber::class,
                ConfigWpSubscriber::class,
                LicenseSubscriber::class,
                SidebarsSubscriber::class,
                SupportSubscriber::class,
                TextDomainSubscriber::class,
                ThumbnailsSubscriber::class,
                PostTypeSupportSubscriber::class,
                MetaBoxesSubscriber::class,
            ]
        ];
    }
}
