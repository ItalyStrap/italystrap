<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Asset\Application;

use ItalyStrap\Asset\Application\EditorSubscriber;
use ItalyStrap\Tests\Shared\Asset\Application\EditorSubscriberTestTrait;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\Theme\Infrastructure\Config\ConfigThemeProvider;
use Prophecy\Argument;

class EditorSubscriberTest extends UnitTestCase
{
    use EditorSubscriberTestTrait;

    private const SITE_URL = 'https://example.test';

    private array $editorStyles = [];

    public function makeIntstance(): EditorSubscriber
    {
        return new EditorSubscriber(
            $this->makeConfig(),
            $this->makeFinder(),
            $this->makeGlobalDispatcher()
        );
    }

    // phpcs:ignore -- Codeception method name.
    protected function _before()
    {
        parent::_before();

        $this->editorStyles = [];
        $this->defineFunction('add_editor_style', function ($stylesheet): void {
            $this->editorStyles = (array) $stylesheet;
        });

        $this->config->get(ConfigThemeProvider::STYLESHEET_DIR)->willReturn('/srv/www/wp-content/themes/child');
        $this->config
            ->get(ConfigThemeProvider::STYLESHEET_DIR_URI)
            ->willReturn(self::SITE_URL . '/wp-content/themes/child');
        $this->config->get(ConfigThemeProvider::TEMPLATE_DIR)->willReturn('/srv/www/wp-content/themes/italystrap');
        $this->config
            ->get(ConfigThemeProvider::TEMPLATE_DIR_URI)
            ->willReturn(self::SITE_URL . '/wp-content/themes/italystrap');

        $this->globalDispatcher
            ->filter('italystrap_visual_editor_style', Argument::type('array'))
            ->will(static fn(array $args): array => $args[1]);
    }

    // phpcs:ignore -- Codeception method name.
    protected function _after()
    {
        $this->undefineFunction('add_editor_style');
        parent::_after();
    }

    private function findFile(string $path): void
    {
        $this->finder->getIterator()->willReturn(new \ArrayIterator([new \SplFileInfo($path)]));
    }

    public function testItAddsTheChildThemeEditorStyle(): void
    {
        $this->findFile('/srv/www/wp-content/themes/child/build/css/editor-style.css');

        $this->makeIntstance()();

        $this->assertSame(
            ['https://example.test/wp-content/themes/child/build/css/editor-style.css'],
            $this->editorStyles
        );
    }

    public function testItAddsTheParentThemeEditorStyleWhenTheChildHasNone(): void
    {
        $this->findFile('/srv/www/wp-content/themes/italystrap/build/css/editor-style.css');

        $this->makeIntstance()();

        $this->assertSame(
            ['https://example.test/wp-content/themes/italystrap/build/css/editor-style.css'],
            $this->editorStyles
        );
    }

    public function testItAddsNothingWhenNoEditorStyleIsFound(): void
    {
        $this->finder->getIterator()->willReturn(new \ArrayIterator([]));

        $this->makeIntstance()();

        $this->assertSame([], $this->editorStyles);
    }
}
