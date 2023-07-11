<?php

declare(strict_types=1);

namespace ItalyStrap\Components;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\EventDispatcherInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\HTML\Tag;
use ItalyStrap\View\ViewInterface;

class Header implements ComponentInterface, SubscriberInterface
{
    use SubscribedEventsAware;

    public const EVENT_NAME = 'italystrap_before_main';
    public const EVENT_PRIORITY = 10;

    public const VIEW = 'header';
    public const BODY_CLASS_NAMES = 'body_class_names';
    public const WRAPPER_CLASS_NAMES = 'wrapper_class_names';

    private ConfigInterface $config;
    private ViewInterface $view;
    private EventDispatcherInterface $dispatcher;
    private Tag $tag;

    public function __construct(
        ConfigInterface $config,
        ViewInterface $view,
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

    public function display(): void
    {
        echo $this->view->render(self::VIEW, [
            EventDispatcherInterface::class => $this->dispatcher,
            Tag::class => $this->tag,
            self::BODY_CLASS_NAMES => \sprintf(
                '%s %s',
                \join(' ', \get_body_class()),
                $this->config->get('current_template_slug')
            ),
            self::WRAPPER_CLASS_NAMES => 'wrapper wp-site-blocks',
        ]);
    }
}
