<?php

declare(strict_types=1);

namespace ItalyStrap\Components;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\View\ViewInterface;

class Comments implements ComponentInterface, SubscriberInterface
{
    use SubscribedEventsAware;

    public const EVENT_NAME = 'italystrap_after_loop';
    public const EVENT_PRIORITY = 10;

    private ConfigInterface $config;
    private ViewInterface $view;

    public function __construct(
        ConfigInterface $config,
        ViewInterface $view
    ) {
        $this->config = $config;
        $this->view = $view;
    }

    public function shouldDisplay(): bool
    {
        return \is_singular()
            && \post_type_supports((string)\get_post_type(), 'comments')
            && ! \in_array('hide_comments', $this->config->get('post_content_template'), true);
    }

    public function display(): void
    {
        echo \do_blocks($this->view->render('comments'));
    }
}
