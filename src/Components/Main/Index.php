<?php

declare(strict_types=1);

namespace ItalyStrap\Components\Main;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\UI\Infrastructure\ViewBlockInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class Index implements ComponentInterface, SubscriberInterface
{
    public function getSubscribedEvents(): iterable
    {
        yield Events\Index::class => $this;
    }

    public const TEMPLATE_NAME = 'main/index';

    private EventDispatcherInterface $dispatcher;

    private ConfigInterface $config;
    private ViewBlockInterface $view;

    public function __construct(
        ConfigInterface $config,
        ViewBlockInterface $view,
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
            'container_class_names' => (string)$this->config->get('container_width', ''),
            'row_class_names' => 'row',
        ]));
    }
}
