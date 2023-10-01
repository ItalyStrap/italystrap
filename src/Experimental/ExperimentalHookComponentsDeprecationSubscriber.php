<?php

declare(strict_types=1);

namespace ItalyStrap\Experimental;

use ItalyStrap\Event\GlobalDispatcher;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\UI\Components\Footer\Events\After as FooterAfter;
use ItalyStrap\UI\Components\Footer\Events\Before as FooterBefore;
use ItalyStrap\UI\Components\Footer\Events\BodyClosing;
use ItalyStrap\UI\Components\Footer\Events\Content as FooterContent;
use ItalyStrap\UI\Components\Header\Events\BodyOpened;
use ItalyStrap\UI\Components\Header\Events\Content as HeaderContent;
use ItalyStrap\UI\Components\Main\Events\Content as IndexContent;
use ItalyStrap\UI\Components\Main\Events\ContentAfter as IndexContentAfter;
use ItalyStrap\UI\Components\Main\Events\ContentBefore as IndexContentBefore;
use ItalyStrap\UI\Components\Main\Events\Footer;
use ItalyStrap\UI\Components\Main\Events\Header;
use ItalyStrap\UI\Components\Main\Events\Index;
use ItalyStrap\UI\Components\Posts\Events\PostContent;
use ItalyStrap\UI\Components\Posts\Events\PostsContent;
use ItalyStrap\UI\Components\Posts\Events\PostsContentAfter;
use ItalyStrap\UI\Components\Posts\Events\PostsContentBefore;
use ItalyStrap\UI\Components\Posts\Events\PostsNotFound;
use ItalyStrap\UI\Components\Posts\Events\PostsNotFoundContent;
use ItalyStrap\UI\Components\Sidebars\Events\After as SidebarAfter;
use ItalyStrap\UI\Components\Sidebars\Events\Before as SideabrBefore;

use function ob_get_clean;
use function ob_start;
use function sprintf;

class ExperimentalHookComponentsDeprecationSubscriber implements SubscriberInterface
{
    private GlobalDispatcher $globalDispatcher;

    public function getSubscribedEvents(): iterable
    {
        yield Header::class => 'onHeader';
        yield HeaderContent::class => 'onHeaderContent';
        yield BodyOpened::class => 'onBodyOpened';

        yield FooterBefore::class => 'onFooterBefore';
        yield FooterAfter::class => 'onFooterAfter';
        yield Footer::class => 'onFooter';
        yield FooterContent::class => 'onFooterContent';
        yield BodyClosing::class => 'onBodyClosing';

        yield SideabrBefore::class => 'onSidebarBefore';
        yield SidebarAfter::class => 'onSidebarAfter';

        yield PostsContent::class => 'onPostsContent';
        yield PostsContentBefore::class => 'onPostsContentBefore';
        yield PostsContentAfter::class => 'onPostsContentAfter';

        yield PostsNotFoundContent::class => 'onPostsNotFoundContent';
        yield PostsNotFound::class => 'onPostsNotFound';

        yield PostContent::class => 'onPostContent';

        yield IndexContent::class => 'onIndexContent';
        yield IndexContentBefore::class => 'onIndexContentBefore';
        yield IndexContentAfter::class => 'onIndexContentAfter';
        yield Index::class => 'onIndex';
    }

    public function __construct(GlobalDispatcher $globalDispatcher)
    {
        $this->globalDispatcher = $globalDispatcher;
    }

    public function onIndex(Index $event)
    {
    }

    public function onIndexContent(IndexContent $event)
    {
        $this->appendContent(
            [
                'italystrap_before_loop',
                'italystrap_loop',
                'italystrap_after_loop',
            ],
            IndexContent::class,
            $event
        );
    }

    public function onIndexContentBefore(IndexContentBefore $event)
    {
        $this->appendContent(['italystrap_before_content'], IndexContentBefore::class, $event);
    }

    public function onIndexContentAfter(IndexContentAfter $event)
    {
        $this->appendContent(['italystrap_after_content'], IndexContentAfter::class, $event);
    }

    public function onPostsContent(PostsContent $event)
    {
        $this->appendContent(
            [
                'italystrap_before_entry',
                'italystrap_entry',
                'italystrap_after_entry',
            ],
            PostsContent::class,
            $event
        );
    }

    public function onPostsContentBefore(PostsContentBefore $event)
    {
        $this->appendContent(['italystrap_before_while'], PostsContentBefore::class, $event);
    }

    public function onPostsContentAfter(PostsContentAfter $event)
    {
        $this->appendContent(['italystrap_after_while'], PostsContentAfter::class, $event);
    }

    public function onPostsNotFoundContent(PostsNotFoundContent $event)
    {
        $this->appendContent(
            [
                'italystrap_before_entry_content_none',
                'italystrap_entry_content_none',
                'italystrap_after_entry_content_none',
            ],
            PostsNotFoundContent::class,
            $event
        );
    }

    public function onPostsNotFound(PostsNotFound $event)
    {
        $this->appendContent(['italystrap_content_none'], PostsNotFound::class, $event);
    }

    public function onPostContent(PostContent $event)
    {
        $this->appendContent(
            [
                'italystrap_before_entry_content',
                'italystrap_entry_content',
                'italystrap_after_entry_content',
            ],
            PostContent::class,
            $event
        );
    }

    public function onSidebarBefore(SideabrBefore $event)
    {
        $this->appendContent(['italystrap_before_sidebar_widget_area'], SideabrBefore::class, $event);
    }

    public function onSidebarAfter(SidebarAfter $event)
    {
        $this->appendContent(['italystrap_after_sidebar_widget_area'], SidebarAfter::class, $event);
    }

    public function onHeader(Header $event)
    {
        $this->appendContent(['italystrap_header'], Header::class, $event);
    }

    public function onHeaderContent(HeaderContent $event)
    {
        $this->appendContent(
            [
                'italystrap_before_header',
                'italystrap_content_header',
                'italystrap_after_header',
            ],
            HeaderContent::class,
            $event
        );
    }

    public function onBodyOpened(BodyOpened $event)
    {
        $this->appendContent(['italystrap_before'], BodyOpened::class, $event);
    }

    public function onFooter(Footer $event)
    {
        $this->appendContent(['italystrap_after_main'], Footer::class, $event);
    }

    public function onFooterContent(FooterContent $event)
    {
        $this->appendContent(['italystrap_footer'], FooterContent::class, $event);
    }

    public function onBodyClosing(BodyClosing $event)
    {
        $this->appendContent(['italystrap_after'], BodyClosing::class, $event);
    }

    public function onFooterBefore(FooterBefore $event)
    {
        $this->appendContent(['italystrap_before_footer'], FooterBefore::class, $event);
    }

    public function onFooterAfter(FooterAfter $event)
    {
        $this->appendContent(['italystrap_after_footer'], FooterAfter::class, $event);
    }

    private function appendContent(array $eventName, string $replacement, object $event): void
    {
        ob_start();
        foreach ($eventName as $name) {
            $this->globalDispatcher->trigger($name);
            $this->deprecatedEventName($name, $replacement);
        }
        $event->appendContent((string)ob_get_clean());
    }

    private function deprecatedEventName(string $eventName, string $replacement): void
    {
        if (
            !\is_user_logged_in()
            || (isset($_SERVER['HTTP_X_TEST_REQUEST']) && isset($_SERVER['HTTP_X_WPBROWSER_REQUEST']))
        ) {
            return;
        }

        _deprecated_hook(
            $eventName,
            '4.0.0',
            sprintf(
                'Use %s instead',
                $replacement
            )
        );
    }
}
