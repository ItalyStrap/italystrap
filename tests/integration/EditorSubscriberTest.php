<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Integration;

use Auryn\ConfigException;
use Auryn\InjectionException;
use ItalyStrap\Asset\Application\EditorSubscriber;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Tests\IntegrationTestCase;
use ItalyStrap\Theme\Infrastructure\Config\ConfigThemeProvider;
use PHPUnit\Framework\Assert;
use function ItalyStrap\Factory\injector;

class EditorSubscriberTest extends IntegrationTestCase
{
    /**
     * @throws ConfigException
     * @throws InjectionException
     */
    private function makeInstance(): EditorSubscriber
    {
        return injector()->make(EditorSubscriber::class);
    }

    /**
     * @test
     */
    public function itShouldEnqueue(): void
    {
        $this->makeInstance()->enqueue();
        global $editor_styles;

        Assert::assertIsArray($editor_styles, '');
        Assert::assertNotEmpty($editor_styles, '');

        $stylesheet_dir_uri = (string)injector()
            ->make(ConfigInterface::class)
            ->get(ConfigThemeProvider::STYLESHEET_DIR_URI);

        Assert::assertSame(
            $stylesheet_dir_uri . '/assets/css/editor-style.css',
            $editor_styles[0],
            ''
        );
    }
}
