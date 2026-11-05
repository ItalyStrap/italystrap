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

    public function __construct(
        private readonly ConfigInterface $config,
        private readonly ViewInterface $view,
        private readonly EventDispatcherInterface $dispatcher,
    ) {
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
