<?php

declare(strict_types=1);

namespace ItalyStrap\Components;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\View\ViewInterface;

class Title implements ComponentInterface, \ItalyStrap\Event\SubscriberInterface
{
    use SubscribedEventsAware;

    public const EVENT_NAME = 'italystrap_entry_content';
    public const EVENT_PRIORITY = 20;

    private ConfigInterface $config;
    private ViewInterface $view;

    public function __construct(ConfigInterface $config, ViewInterface $view)
    {
        $this->config = $config;
        $this->view = $view;
    }

    public function shouldDisplay(): bool
    {
        return \post_type_supports((string)\get_post_type(), 'title')
            && ! \in_array('hide_title', (array)$this->config->get('post_content_template', []), true);
    }

    public function display(): void
    {

        $post_title_config = [
            "level" => \is_singular() ? 1 : 2,
            "isLink" => true,
            "rel" => "bookmark",
            "className" => "entry-title",
        ];

        echo \do_blocks($this->view->render('temp/title', $post_title_config));
    }
}
