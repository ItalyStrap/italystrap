<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Components\Footer;

use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\HTML\TagInterface;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\View\ViewInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class Footer implements ComponentInterface, SubscriberInterface
{
    public function getSubscribedEvents(): iterable
    {
        yield \ItalyStrap\UI\Components\Main\Events\Footer::class => $this;
    }

    public const TEMPLATE_NAME = 'footer/footer';

    public function __construct(
        private ViewInterface $view,
        private TagInterface $tag,
        private EventDispatcherInterface $dispatcher,
    ) {
    }

    public function shouldDisplay(): bool
    {
        return true;
    }

    public function __invoke(\ItalyStrap\UI\Components\Main\Events\Footer $event): void
    {
        $event->appendContent($this->view->render(self::TEMPLATE_NAME, [
            EventDispatcherInterface::class => $this->dispatcher,
            TagInterface::class => $this->tag,
        ]));
    }
}
