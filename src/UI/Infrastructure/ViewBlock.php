<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Infrastructure;

use ItalyStrap\View\ViewInterface;

use function do_blocks;

class ViewBlock implements ViewBlockInterface
{
    private ViewInterface $view;

    public function __construct(ViewInterface $view)
    {
        $this->view = $view;
    }

    public function render($slugs, $data = []): string
    {
        return do_blocks($this->view->render($slugs, $data));
    }
}
