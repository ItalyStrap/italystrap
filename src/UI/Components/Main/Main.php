<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Components\Main;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\View\ViewInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class Main implements ComponentInterface, SubscriberInterface
{
    public function getSubscribedEvents(): iterable
    {
        yield Events\Canvas::class => $this;
    }

    public const TEMPLATE_NAME = 'main/main';

    private EventDispatcherInterface $dispatcher;

    private ConfigInterface $config;
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

    public function __invoke(Events\Canvas $event): void
    {
        $event->appendContent($this->view->render(self::TEMPLATE_NAME, [
            EventDispatcherInterface::class => $this->dispatcher,
            'container_class_names' => (string)$this->config->get('container_width', ''),
            'row_class_names' => 'row',
        ]));
    }
}
