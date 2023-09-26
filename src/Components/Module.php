<?php

declare(strict_types=1);

namespace ItalyStrap\Components;

use ItalyStrap\Components\Footer\Colophon;
use ItalyStrap\Components\Footer\Footer;
use ItalyStrap\Components\Footer\FooterWidgetArea;
use ItalyStrap\Components\Header\CustomHeaderImage;
use ItalyStrap\Components\Header\Header;
use ItalyStrap\Components\Header\SiteLogo;
use ItalyStrap\Components\Header\SiteTitle;
use ItalyStrap\Components\Main\Index;
use ItalyStrap\Empress\AurynConfig;

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

            ],

            /**
             * ========================================================================
             *
             * Components Subscriber Classes
             *
             * ========================================================================
             */
            ComponentSubscriberExtension::class => [

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

                CustomHeaderImage::class,

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
