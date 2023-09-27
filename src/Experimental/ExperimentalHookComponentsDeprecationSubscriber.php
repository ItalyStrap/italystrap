<?php

declare(strict_types=1);

namespace ItalyStrap\Experimental;

use ItalyStrap\Components\Footer\Events\Content as FooterContent;
use ItalyStrap\Components\Header\Events\Content as HeaderContent;
use ItalyStrap\Components\Main\Events\Content as IndexContent;
use ItalyStrap\Components\Main\Events\ContentAfter as IndexContentAfter;
use ItalyStrap\Components\Main\Events\ContentBefore as IndexContentBefore;
use ItalyStrap\Components\Main\Events\Footer;
use ItalyStrap\Components\Main\Events\Header;
use ItalyStrap\Components\Main\Events\Index;
use ItalyStrap\Event\GlobalDispatcher;
use ItalyStrap\Event\SubscriberInterface;

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
        yield Footer::class => 'onFooter';
        yield FooterContent::class => 'onFooterContent';

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

    public function onFooter(Footer $event)
    {
        $this->appendContent(['italystrap_after_main'], Footer::class, $event);
    }

    public function onFooterContent(FooterContent $event)
    {
        $this->appendContent(['italystrap_footer'], FooterContent::class, $event);
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
