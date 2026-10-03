<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Infrastructure;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Theme\Infrastructure\Config\ConfigThemeProvider;
use ItalyStrap\View\ViewInterface;

class ViewBlockTemplatePart implements ViewInterface
{
    private ConfigInterface $config;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * @param array<string>|string $slugs
     * @param $data
     * @return string
     */
    public function render($slugs, $data = []): string
    {
        $styleSheet = $this->config->get(ConfigThemeProvider::STYLESHEET);

        $output = '';
        foreach ((array) $slugs as $slug) {
            $part = \explode('/', $slug);
            $part = \end($part);
            $part = \str_replace('.php', '', $part);

            $template_part = \get_block_template(
                $styleSheet . '//' . $part,
                'wp_template_part'
            );

            if ($template_part === null) {
                continue;
            }

            if (
                $template_part instanceof \WP_Block_Template
                && property_exists($template_part, 'content')
            ) {
                $output .= (string)$template_part->content;
            }

            if ($template_part instanceof \WP_Error) {
                throw new \RuntimeException(\sprintf(
                    'Error loading template part %s: %s',
                    $slug,
                    $template_part->get_error_message()
                ));
            }
        }

        return $output;
    }
}
