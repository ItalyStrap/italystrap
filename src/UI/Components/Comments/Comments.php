<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Components\Comments;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Main\Events\Content;
use ItalyStrap\UI\Infrastructure\ViewBlockInterface;

class Comments implements ComponentInterface, SubscriberInterface
{
    public function getSubscribedEvents(): iterable
    {
        yield Content::class => [
            SubscriberInterface::CALLBACK => $this,
            SubscriberInterface::PRIORITY => 20,
        ];
    }

    public const TEMPLATE_NAME = 'comments/comments';

    private ConfigInterface $config;
    private ViewBlockInterface $view;
    public function __construct(ConfigInterface $config, ViewBlockInterface $view)
    {
        $this->config = $config;
        $this->view = $view;
    }

    public function shouldDisplay(): bool
    {
        return \is_singular()
            && \post_type_supports((string)\get_post_type(), 'comments')
            && ! \in_array('hide_comments', $this->config->get('post_content_template'), true);
    }

    public function __invoke(Content $event): void
    {
        $event->appendContent($this->view->render(self::TEMPLATE_NAME));
    }
}
