<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Components\Posts\Parts;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Posts\Events\PostContent;
use ItalyStrap\View\ViewInterface;

class Content implements SubscriberInterface, ComponentInterface
{
    public const EVENT_PRIORITY = 50;

    public function getSubscribedEvents(): iterable
    {
        yield PostContent::class => [
            SubscriberInterface::CALLBACK => $this,
            SubscriberInterface::PRIORITY => self::EVENT_PRIORITY,
        ];
    }

    public const TEMPLATE_NAME = 'posts/parts/content';

    private ConfigInterface $config;
    private ViewInterface $view;

    public function __construct(ConfigInterface $config, ViewInterface $view)
    {
        $this->config = $config;
        $this->view = $view;
    }

    public function shouldDisplay(): bool
    {
        return \is_singular()
            && \post_type_supports((string)\get_post_type(), 'editor')
            && ! \in_array('hide_content', (array)$this->config->get('post_content_template', []), true);
    }

    public function __invoke(PostContent $event): void
    {
        $event->appendContent($this->view->render(self::TEMPLATE_NAME, []));
    }
}
