<?php

declare(strict_types=1);

namespace ItalyStrap\UI;

use ItalyStrap\Components\ArchiveAuthorInfo;
use ItalyStrap\Components\ArchiveHeadline;
use ItalyStrap\Components\AuthorInfo;
use ItalyStrap\Components\Comments;
use ItalyStrap\Components\Content;
use ItalyStrap\Components\Entry;
use ItalyStrap\Components\EntryNone;
use ItalyStrap\Components\EntryNoneContent;
use ItalyStrap\Components\EntryNoneImage;
use ItalyStrap\Components\EntryNoneTitle;
use ItalyStrap\Components\Excerpt;
use ItalyStrap\Components\FeaturedImage;
use ItalyStrap\Components\Footer\Colophon;
use ItalyStrap\Components\Footer\Footer;
use ItalyStrap\Components\Footer\FooterWidgetArea;
use ItalyStrap\Components\Header\CustomHeaderImage;
use ItalyStrap\Components\Header\Header;
use ItalyStrap\Components\Header\SiteLogo;
use ItalyStrap\Components\Header\SiteTitle;
use ItalyStrap\Components\Loop;
use ItalyStrap\Components\Main\Index;
use ItalyStrap\Components\Meta;
use ItalyStrap\Components\Modified;
use ItalyStrap\Components\PostAuthorInfo;
use ItalyStrap\Components\Preview;
use ItalyStrap\Components\Sidebar;
use ItalyStrap\Components\Title;
use ItalyStrap\Empress\AurynConfig;
use ItalyStrap\UI\Infrastructure\ComponentSubscriberExtension;
use ItalyStrap\UI\Infrastructure\ViewBlock;
use ItalyStrap\UI\Infrastructure\ViewBlockInterface;

class Module
{
    public function __invoke(): array
    {
        return  [
            AurynConfig::SHARING => [
                ViewBlockInterface::class,
                AuthorInfo::class,
            ],
            AurynConfig::ALIASES => [
                ViewBlockInterface::class => ViewBlock::class,
            ],
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
