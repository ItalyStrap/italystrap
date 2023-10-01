<?php

declare(strict_types=1);

namespace ItalyStrap\UI;

use ItalyStrap\Components\ArchiveAuthorInfo;
use ItalyStrap\Components\ArchiveHeadline;
use ItalyStrap\Components\AuthorInfo;
use ItalyStrap\Components\Header\SiteLogo;
use ItalyStrap\Components\Header\SiteTitle;
use ItalyStrap\Components\Modified;
use ItalyStrap\Components\PostAuthorInfo;
use ItalyStrap\Empress\AurynConfig;
use ItalyStrap\UI\Components\Comments\Comments;
use ItalyStrap\UI\Components\Footer\Colophon;
use ItalyStrap\UI\Components\Footer\Footer;
use ItalyStrap\UI\Components\Footer\FooterWidgetArea;
use ItalyStrap\UI\Components\Header\CustomHeaderImage;
use ItalyStrap\UI\Components\Header\Header;
use ItalyStrap\UI\Components\Main\Index;
use ItalyStrap\UI\Components\Posts\NotFound;
use ItalyStrap\UI\Components\Posts\NotFound\Content as NotFoundContent;
use ItalyStrap\UI\Components\Posts\NotFound\Image as NotFoundImage;
use ItalyStrap\UI\Components\Posts\NotFound\Title as NotFoundTitle;
use ItalyStrap\UI\Components\Posts\Parts\Content;
use ItalyStrap\UI\Components\Posts\Parts\Excerpt;
use ItalyStrap\UI\Components\Posts\Parts\FeaturedImage;
use ItalyStrap\UI\Components\Posts\Parts\Meta;
use ItalyStrap\UI\Components\Posts\Parts\Preview;
use ItalyStrap\UI\Components\Posts\Parts\Title;
use ItalyStrap\UI\Components\Posts\Post;
use ItalyStrap\UI\Components\Posts\Posts;
use ItalyStrap\UI\Components\Sidebars\Sidebar;
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
            AurynConfig::DEFINITIONS => [

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

                Post::class,

                NotFoundImage::class,
                NotFoundTitle::class,
                NotFoundContent::class,
                NotFound::class,

                Posts::class,

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
