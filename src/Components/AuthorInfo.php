<?php

declare(strict_types=1);

namespace ItalyStrap\Components;

use ItalyStrap\View\ViewInterface;
use ItalyStrap\Event\SubscriberInterface;

class AuthorInfo implements ViewInterface
{
    private ViewInterface $view;

    public function __construct(ViewInterface $view)
    {
        $this->view = $view;
    }

    public function render($slugs, $data = []): string
    {
        return \do_shortcode(\do_blocks($this->view->render($slugs ?? 'temp/author-info', $data)));
    }
}
