<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Integration\Theme;

use ItalyStrap\Config\ConfigFactory;
use ItalyStrap\Tests\IntegrationTestCase;
use ItalyStrap\Theme\Application\SupportSubscriber;
use ItalyStrap\Theme\Infrastructure\Config\ConfigThemeSupportProvider;
use ItalyStrap\Theme\Infrastructure\Support;

use function ItalyStrap\Factory\injector;

class SupportSubscriberTest extends IntegrationTestCase
{
    public static function supportProvider(): iterable
    {
        yield 'Automatic Feed Links' => [
            'automatic-feed-links',
        ];

        yield 'Post Thumbnails' => [
            'post-thumbnails',
        ];

//        yield 'HTML5' => [
//            'html5',
//        ];

        yield 'Title Tag' => [
            'title-tag',
        ];

        yield 'Post Formats' => [
            'post-formats',
        ];

        yield 'Custom Header' => [
            ConfigThemeSupportProvider::CUSTOM_HEADER,
        ];

        yield 'Custom Logo' => [
            ConfigThemeSupportProvider::CUSTOM_LOGO,
        ];

        yield 'Custom Background' => [
            'custom-background',
        ];

        yield 'Customize selective refresh widgets' => [
            'customize-selective-refresh-widgets',
        ];

        yield 'Breadcrumbs' => [
            'breadcrumbs',
        ];

        /**
         * Gutenberg stuff
         */

        yield 'Align Wide' => [
            'align-wide',
        ];

        yield 'Editor Styles' => [
            'editor-styles',
        ];

        yield 'Responsive Embeds' => [
            'responsive-embeds',
        ];

        yield 'WP Block Styles' => [
            'wp-block-styles',
        ];

        yield 'Block template parts' => [
            'block-template-parts',
        ];
    }

    /**
     * @dataProvider supportProvider
     */
    public function testItShouldHadRegisteredSupport(string $feature)
    {
        $support = new Support();
        $this->assertTrue($support->has($feature), 'Should has support for ' . $feature);
    }
}
