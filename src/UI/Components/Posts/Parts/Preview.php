<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Components\Posts\Parts;

use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Posts\Events\PostContent;
use ItalyStrap\View\ViewInterface;

class Preview implements ComponentInterface, SubscriberInterface
{
    public const EVENT_PRIORITY = 40;

    public function getSubscribedEvents(): iterable
    {
        yield PostContent::class => [
            SubscriberInterface::CALLBACK => $this,
            SubscriberInterface::PRIORITY => self::EVENT_PRIORITY,
        ];
    }

    public const TEMPLATE_NAME = 'posts/parts/preview';

    private ViewInterface $view;

    public function __construct(
        ViewInterface $view
    ) {
        $this->view = $view;
    }

    public function shouldDisplay(): bool
    {
        return \is_preview();
    }

    public function __invoke(PostContent $event): void
    {
        $event->appendContent($this->view->render(self::TEMPLATE_NAME, []));
    }
}
