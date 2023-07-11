<?php

declare(strict_types=1);

namespace ItalyStrap\Components;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\View\ViewInterface;

class Pager implements SubscriberInterface, ComponentInterface
{
    use SubscribedEventsAware;

    public const EVENT_NAME = 'italystrap_after_entry_content';
    public const EVENT_PRIORITY = 10;

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

    public function display(): void
    {
        echo \do_blocks($this->view->render('temp/pager', []));
    }
}
