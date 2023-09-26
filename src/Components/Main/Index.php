<?php

declare(strict_types=1);

namespace ItalyStrap\Components\Main;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\EventDispatcherInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\View\ViewInterface;

class Index implements ComponentInterface, SubscriberInterface
{
    public function getSubscribedEvents(): iterable
    {
        yield Events\Index::class => $this;
    }

    public const TEMPLATE_NAME = 'main/index';

    private ConfigInterface $config;
    private ViewInterface $view;
    private EventDispatcherInterface $globalDispatcher;

    public function __construct(
        ConfigInterface $config,
        ViewInterface $view,
        EventDispatcherInterface $globalDispatcher
    ) {
        $this->config = $config;
        $this->view = $view;
        $this->globalDispatcher = $globalDispatcher;
    }

    public function shouldDisplay(): bool
    {
        return true;
    }

    public function __invoke(Events\Index $event): void
    {
        $event->appendContent(\do_blocks($this->view->render(self::TEMPLATE_NAME, [
            EventDispatcherInterface::class => $this->globalDispatcher,
            'container_class_names' => $this->config->get('container_width'),
            'row_class_names' => 'row',
        ])));
    }
}
