<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Components\Main;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\View\ViewInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class Canvas implements ComponentInterface, SubscriberInterface
{
    public function getSubscribedEvents(): iterable
    {
        yield Events\Index::class => $this;
    }

    public const TEMPLATE_NAME = 'main/canvas';
    public const BODY_CLASS_NAMES = 'body_class_names';

    private ConfigInterface $config;

    private EventDispatcherInterface $dispatcher;
    private ViewInterface $view;

    public function __construct(
        ConfigInterface $config,
        ViewInterface $view,
        EventDispatcherInterface $dispatcher
    ) {
        $this->config = $config;
        $this->view = $view;
        $this->dispatcher = $dispatcher;
    }

    public function shouldDisplay(): bool
    {
        return true;
    }

    public function __invoke(Events\Index $event): void
    {
        $event->appendContent($this->view->render(self::TEMPLATE_NAME, [
            EventDispatcherInterface::class => $this->dispatcher,
            self::BODY_CLASS_NAMES => \sprintf(
                '%s %s',
                \join(' ', \get_body_class()),
                $this->config->get('current_template_slug')
            ),
        ]));
    }
}
