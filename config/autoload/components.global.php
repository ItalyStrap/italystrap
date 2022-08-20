<?php
declare(strict_types=1);

use Auryn\Injector;
use ItalyStrap\Components\ArchiveAuthorInfo;
use ItalyStrap\Components\ArchiveHeadline;
use ItalyStrap\Components\AuthorInfo;
use ItalyStrap\Components\BlockQuery;
use ItalyStrap\Components\Breadcrumbs;
use ItalyStrap\Components\Colophon;
use ItalyStrap\Components\Comments;
use ItalyStrap\Components\ComponentSubscriberExtension;
use ItalyStrap\Components\Content;
use ItalyStrap\Components\CustomHeaderImage;
use ItalyStrap\Components\Entry;
use ItalyStrap\Components\EntryNone;
use ItalyStrap\Components\EntryNoneContent;
use ItalyStrap\Components\EntryNoneImage;
use ItalyStrap\Components\EntryNoneTitle;
use ItalyStrap\Components\Excerpt;
use ItalyStrap\Components\FeaturedImage;
use ItalyStrap\Components\Footer;
use ItalyStrap\Components\FooterWidgetArea;
use ItalyStrap\Components\Header;
use ItalyStrap\Components\Index;
use ItalyStrap\Components\Loop;
use ItalyStrap\Components\MainNavigation;
use ItalyStrap\Components\MainNavigationOlder;
use ItalyStrap\Components\Meta;
use ItalyStrap\Components\MiscNavigation;
use ItalyStrap\Components\Modified;
use ItalyStrap\Components\NavMenuHeader;
use ItalyStrap\Components\NavMenuPrimary;
use ItalyStrap\Components\NavMenuSecondary;
use ItalyStrap\Components\NavMenuToggleButton;
use ItalyStrap\Components\Pager;
use ItalyStrap\Components\Pagination;
use ItalyStrap\Components\PostAuthorInfo;
use ItalyStrap\Components\Preview;
use ItalyStrap\Components\Sidebar;
use ItalyStrap\Components\SiteLogo;
use ItalyStrap\Components\SiteTagline;
use ItalyStrap\Components\SiteTitle;
use ItalyStrap\Components\Title;
use ItalyStrap\Empress\AurynConfig;

return [
	AurynConfig::SHARING => [
		AuthorInfo::class,
	],

	AurynConfig::ALIASES => [

	],

	AurynConfig::DEFINITIONS => [

		\ItalyStrap\Components\Navigations\Navbar::class	=> [
			':fallback_cb' => [ \ItalyStrap\Navbar\BootstrapNavMenu::class, 'fallback' ],
		],

		PostAuthorInfo::class => [
			'+view' => static function ( string $named_param, Injector $injector ): AuthorInfo {
				return $injector->make( AuthorInfo::class );
			}
		],
		ArchiveAuthorInfo::class => [
			'+view' => static function ( string $named_param, Injector $injector ): AuthorInfo {
				return $injector->make( AuthorInfo::class );
			}
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
//		BlockQuery::class,

		Sidebar::class,

		Entry::class,

		EntryNoneImage::class,
		EntryNoneTitle::class,
		EntryNoneContent::class,
		EntryNone::class,

		Loop::class,

		SiteLogo::class,
		SiteTitle::class,
//		SiteTagline::class,

		MiscNavigation::class,
		CustomHeaderImage::class,

		NavMenuToggleButton::class,
		NavMenuHeader::class,
		NavMenuPrimary::class,
		NavMenuSecondary::class,
		MainNavigationOlder::class,
		MainNavigation::class,

		Comments::class,
		Colophon::class,
		Header::class,
		FooterWidgetArea::class,
		Footer::class,
		Index::class => Index::class,
	],
];
