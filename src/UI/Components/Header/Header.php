<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Components\Header;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\HTML\Tag;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Infrastructure\ViewBlockInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class Header implements ComponentInterface, SubscriberInterface
{
    public function getSubscribedEvents(): iterable
    {
        yield \ItalyStrap\UI\Components\Main\Events\Header::class => $this;
    }

    public const TEMPLATE_NAME = 'header/header';
    public const BODY_CLASS_NAMES = 'body_class_names';
    public const WRAPPER_CLASS_NAMES = 'wrapper_class_names';

    private ConfigInterface $config;
    private ViewBlockInterface $view;
    private Tag $tag;
    private EventDispatcherInterface $dispatcher;

    public function __construct(
        ConfigInterface $config,
        ViewBlockInterface $view,
        EventDispatcherInterface $dispatcher,
        Tag $tag
    ) {
        $this->config = $config;
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
            Tag::class => $this->tag,
            self::BODY_CLASS_NAMES => \sprintf(
                '%s %s',
                \join(' ', \get_body_class()),
                (string)$this->config->get('current_template_slug')
            ),
            self::WRAPPER_CLASS_NAMES => 'wrapper wp-site-blocks',
        ]));
    }
}
