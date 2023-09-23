<?php

declare(strict_types=1);

namespace ItalyStrap\Components;

use ItalyStrap\Components\Footer\Colophon;
use ItalyStrap\Components\Footer\Footer;
use ItalyStrap\Components\Footer\FooterWidgetArea;
use ItalyStrap\Components\Main\Index;
use ItalyStrap\Empress\AurynConfig;
use ItalyStrap\Empress\Injector;
use ItalyStrap\Navigation\NavMenuFallback;

class Module
{
    public function __invoke(): iterable
    {
        return [
            AurynConfig::SHARING => [
                AuthorInfo::class,
            ],

            AurynConfig::ALIASES => [

            ],

            AurynConfig::DEFINITIONS => [

                \ItalyStrap\Components\Navigations\Navbar::class    => [
                    ':fallback_cb' => [ \ItalyStrap\Navbar\BootstrapNavMenu::class, 'fallback' ],
                ],

                NavMenuPrimary::class => [
                    '+fallback' => static function (string $named_param, Injector $injector): callable {

                        return $injector->make(NavMenuFallback::class);
                    },
                ],
            ],

            /**
             * ========================================================================
             *
             * Components Subscriber Classes
             *
             * ========================================================================
             */
            ComponentSubscriberExtension::class => [

                Breadcrumbs::class,

                PostAuthorInfo::class,
                ArchiveAuthorInfo::class,
                ArchiveHeadline::class,

                FeaturedImage::class,
                Title::class,
                Meta::class,
                Preview::class,
                Content::class,
                Excerpt::class,
                Modified::class,
                Pager::class,
                Pagination::class,
                //     BlockQuery::class,

                Sidebar::class,

                Entry::class,

                EntryNoneImage::class,
                EntryNoneTitle::class,
                EntryNoneContent::class,
                EntryNone::class,

                Loop::class,

                SiteLogo::class,
                SiteTitle::class,
                //       SiteTagline::class,

                MiscNavigation::class,
                CustomHeaderImage::class,

                NavMenuToggleButton::class,
                NavMenuHeader::class,
                NavMenuPrimary::class,
                NavMenuSecondary::class,
                MainNavigationOlder::class,
                //     MainNavigation::class,

                Comments::class,
                Colophon::class,
                Header::class,
                FooterWidgetArea::class,
                Footer::class,
                Index::class => Index::class,
            ],
        ];
    }
}