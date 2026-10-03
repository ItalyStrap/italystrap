<?php

declare(strict_types=1);

namespace ItalyStrap\Asset\Application;

use ItalyStrap\Asset\Infrastructure\InlineStyleGenerator;
use ItalyStrap\Config\ConfigColorSectionProvider;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Theme\Infrastructure\Config\ConfigThemeProvider;

class InlineStyleSubscriber implements SubscriberInterface
{
    private ConfigInterface $config;
    private InlineStyleGenerator $style;

    public function getSubscribedEvents(): iterable
    {
        yield 'wp_head' => [
            self::CALLBACK  => $this,
            self::PRIORITY  => 11,
        ];
    }

    public function __construct(ConfigInterface $config, InlineStyleGenerator $style)
    {
        $this->style = $style;
        $this->config = $config;
    }

    public function __invoke(): void
    {
        $output = $this->style->render(
            '#site-title a',
            'color',
            ConfigColorSectionProvider::HEADER_COLOR,
            '#'
        );

        $output .= $this->style->render(
            'h1,h2,h3,h4,h5,h6,.h1,.h2,.h3,.h4,.h5,.h6,.heading',
            'color',
            ConfigColorSectionProvider::HX_COLOR,
            '#'
        );

        $output .= $this->style->render(
            'a',
            'color',
            ConfigColorSectionProvider::LINK_COLOR,
            '#'
        );

        if (! $output) {
            return;
        }

        \printf(
            '<style id="%s-global-styles-inline-css">%s</style>',
            (string) $this->config->get(ConfigThemeProvider::PREFIX),
            \wp_strip_all_tags($this->minifyOutput($output))
        );
    }

    private function minifyOutput(string $style): string
    {
        return \str_replace(
            [
                "\n",
                "\r",
                "\t",
                '&amp;nbsp;',
            ],
            '',
            $style
        );
    }
}
