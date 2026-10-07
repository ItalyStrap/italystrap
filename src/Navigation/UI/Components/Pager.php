<?php

declare(strict_types=1);

namespace ItalyStrap\Navigation\UI\Components;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Posts\Events\PostContent;
use ItalyStrap\View\ViewInterface;

class Pager implements SubscriberInterface, ComponentInterface
{
    // After the content (50) and before the modified date (60), where the v3 hook fired.
    public const EVENT_PRIORITY = 55;

    public const TEMPLATE_NAME = 'navigation/pager';

    public function getSubscribedEvents(): iterable
    {
        yield PostContent::class => [
            SubscriberInterface::CALLBACK => $this,
            SubscriberInterface::PRIORITY => self::EVENT_PRIORITY,
        ];
    }

    private ConfigInterface $config;
    private ViewInterface $view;

    public function __construct(ConfigInterface $config, ViewInterface $view)
    {
        $this->config = $config;
        $this->view = $view;
    }

    public function shouldDisplay(): bool
    {
        return \is_single()
            && \post_type_supports((string)\get_post_type(), 'post_navigation');
    }

    public function __invoke(PostContent $event): void
    {
        $event->appendContent(\do_blocks($this->view->render(self::TEMPLATE_NAME)));
    }
}
