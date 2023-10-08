<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Infrastructure;

use ItalyStrap\View\ViewInterface;

class ViewBlockTemplatePart implements ViewInterface
{
    public function __construct()
    {
    }

    public function render($slugs, $data = []): string
    {
        foreach ((array) $slugs as $slug) {
            $part = \explode('/', $slug);
            $part = \end($part);
            $part = \str_replace('.php', '', $part);

            $template_part = \get_block_template(
                \get_stylesheet() . '//' . $part,
                'wp_template_part'
            );

            if (! empty($template_part)) {
                return (string)$template_part->content;
            }
        }

        return '';
    }
}
