<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Infrastructure;

use ItalyStrap\View\ViewInterface;

use function do_blocks;

class ViewBlock implements ViewBlockInterface
{
    public function __construct(private readonly ViewInterface $view)
    {
    }

    public function render($slugs, $data = []): string
    {
        return do_blocks($this->view->render($slugs, $data));
    }
}
