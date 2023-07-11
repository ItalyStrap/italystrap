<?php

declare(strict_types=1);

namespace ItalyStrap\Components;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\View\ViewInterface;

class Meta implements ComponentInterface, SubscriberInterface
{
    use SubscribedEventsAware;

    public const EVENT_NAME = 'italystrap_entry_content';
    public const EVENT_PRIORITY = 30;

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
            && ! \in_array('hide_meta', $this->config->get('post_content_template'), true);
    }

    public function display(): void
    {
        echo \do_blocks($this->view->render('temp/meta', []));
    }
}
