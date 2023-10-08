<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Components\Posts\Parts;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Posts\Events\PostContent;
use ItalyStrap\View\ViewInterface;

class Meta implements ComponentInterface, SubscriberInterface
{
    public const EVENT_PRIORITY = 30;

    public function getSubscribedEvents(): iterable
    {
        yield PostContent::class => [
            SubscriberInterface::CALLBACK => $this,
            SubscriberInterface::PRIORITY => self::EVENT_PRIORITY,
        ];
    }

    public const TEMPLATE_NAME = 'posts/parts/meta';

    private ConfigInterface $config;
    private ViewInterface $view;

    public function __construct(ConfigInterface $config, ViewInterface $view)
    {
        $this->config = $config;
        $this->view = $view;
    }

    public function shouldDisplay(): bool
    {
        return \post_type_supports((string)\get_post_type(), 'entry-meta')
            && ! \in_array('hide_meta', (array)$this->config->get('post_content_template', []), true);
    }

    public function __invoke(PostContent $event): void
    {
        $event->appendContent($this->view->render(self::TEMPLATE_NAME, []));
    }
}
