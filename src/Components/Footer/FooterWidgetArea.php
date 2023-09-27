<?php

declare(strict_types=1);

namespace ItalyStrap\Components\Footer;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Components\Footer\Events\Content;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Theme\Infrastructure\Config\ConfigSidebarProvider;
use ItalyStrap\View\ViewInterface;

class FooterWidgetArea implements ComponentInterface, SubscriberInterface
{
    public function getSubscribedEvents(): iterable
    {
        yield Content::class   => $this;
    }

    public const TEMPLATE_NAME = 'footer/widget-area';

    private ViewInterface $view;

    public function __construct(
        ViewInterface $view
    ) {
        $this->view = $view;
    }

    public function shouldDisplay(): bool
    {
        return true;
    }

    public function __invoke(Content $event): void
    {
        $event->appendContent(\do_blocks($this->view->render(self::TEMPLATE_NAME, [
            'footer_sidebars' => ConfigSidebarProvider::FOOTERS,
        ])));
    }
}
