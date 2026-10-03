<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Components\Site;

use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Navigation\UI\Components\Events\NavMenuHeaderContent;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\View\ViewInterface;

class Tagline implements ComponentInterface, SubscriberInterface
{
    public const EVENT_PRIORITY = 10;

    public function getSubscribedEvents(): iterable
    {
        yield NavMenuHeaderContent::class => [
            SubscriberInterface::CALLBACK => $this,
            SubscriberInterface::PRIORITY => self::EVENT_PRIORITY,
        ];
    }

    public const ATTRIBUTES = 'attributes';

    public const TEMPLATE_NAME = 'site/tagline';
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

    public function __invoke(NavMenuHeaderContent $event): void
    {
        $event->appendContent($this->view->render(self::TEMPLATE_NAME));
    }
}
