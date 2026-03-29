<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Components\Header;

use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\HTML\TagInterface;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\View\ViewInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class Header implements ComponentInterface, SubscriberInterface
{
    public function getSubscribedEvents(): iterable
    {
        yield \ItalyStrap\UI\Components\Main\Events\Header::class => $this;
    }

    public const TEMPLATE_NAME = 'header/header';
    public const WRAPPER_CLASS_NAMES = 'wrapper_class_names';

    private ViewInterface $view;
    private TagInterface $tag;
    private EventDispatcherInterface $dispatcher;

    public function __construct(
        ViewInterface $view,
        EventDispatcherInterface $dispatcher,
        TagInterface $tag
    ) {
        $this->view = $view;
        $this->dispatcher = $dispatcher;
        $this->tag = $tag;
    }

    public function shouldDisplay(): bool
    {
        return true;
    }

    public function __invoke(\ItalyStrap\UI\Components\Main\Events\Header $event): void
    {
        $event->appendContent($this->view->render(self::TEMPLATE_NAME, [
            EventDispatcherInterface::class => $this->dispatcher,
            TagInterface::class => $this->tag,
            self::WRAPPER_CLASS_NAMES => 'wrapper wp-site-blocks',
        ]));
    }
}
