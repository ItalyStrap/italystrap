<?php

declare(strict_types=1);

namespace ItalyStrap\Components\Footer;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Theme\Infrastructure\Config\ConfigSidebarProvider;
use ItalyStrap\View\ViewInterface;

class FooterWidgetArea implements ComponentInterface, SubscriberInterface
{
    public const TEMPLATE_NAME = 'footer/widget-area';

    private ViewInterface $view;

    public function getSubscribedEvents(): iterable
    {
        yield \ItalyStrap\Components\Footer\Events\Footer::class   => $this;
    }

    public function __construct(
        ViewInterface $view
    ) {
        $this->view = $view;
    }

    public function shouldDisplay(): bool
    {
        return true;
    }

    public function __invoke(\ItalyStrap\Components\Footer\Events\Footer $event): void
    {
        $event->appendContent(\do_blocks($this->view->render(self::TEMPLATE_NAME, [
            'footer_sidebars' => ConfigSidebarProvider::FOOTERS,
        ])));
    }
}
