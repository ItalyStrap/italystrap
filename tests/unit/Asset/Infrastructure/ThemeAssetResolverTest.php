<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Asset\Infrastructure;

use ItalyStrap\Asset\Infrastructure\ThemeAssetResolver;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\Theme\Infrastructure\Config\ConfigThemeProvider;

class ThemeAssetResolverTest extends UnitTestCase
{
    private string $tmpDir;

    protected function _before(): void
    {
        parent::_before();

        $this->tmpDir = sys_get_temp_dir() . '/italystrap-theme-asset-resolver-test-' . uniqid();
        mkdir($this->tmpDir . '/build/js', 0777, true);
        mkdir($this->tmpDir . '/build/css', 0777, true);
        mkdir($this->tmpDir . '/build/customizer', 0777, true);

        $this->config->get(ConfigThemeProvider::STYLESHEET_DIR)->willReturn($this->tmpDir . '/child');
        $this->config->get(ConfigThemeProvider::STYLESHEET_DIR_URI)->willReturn('http://test/wp-content/themes/child');
        $this->config->get(ConfigThemeProvider::TEMPLATE_DIR)->willReturn($this->tmpDir);
        $this->config->get(ConfigThemeProvider::TEMPLATE_DIR_URI)->willReturn('http://test/wp-content/themes/italystrap');
    }

    protected function _after(): void
    {
        parent::_after();
        $files = array_merge(
            glob($this->tmpDir . '/build/js/*') ?: [],
            glob($this->tmpDir . '/build/css/*') ?: [],
            glob($this->tmpDir . '/build/customizer/*') ?: []
        );
        array_map('unlink', $files);
        array_map('rmdir', [
            $this->tmpDir . '/build/js',
            $this->tmpDir . '/build/css',
            $this->tmpDir . '/build/customizer',
            $this->tmpDir . '/build',
            $this->tmpDir,
        ]);
    }

    private function makeInstance(): ThemeAssetResolver
    {
        return new ThemeAssetResolver($this->makeConfig());
    }

    public function testItResolvesUrlForExistingFileInParentTheme(): void
    {
        $js_path = $this->tmpDir . '/build/js/index.js';
        file_put_contents($js_path, '// js');

        $sut = $this->makeInstance();
        $result = $sut->resolve('build/js/index.js');

        self::assertSame(
            'http://test/wp-content/themes/italystrap/build/js/index.js',
            $result['url'],
            ''
        );
        self::assertIsString($result['version'], '');
        self::assertSame([], $result['dependencies'], '');
    }

    public function testItPopulatesDepsAndVersionFromAssetPhpWhenPresent(): void
    {
        $js_path = $this->tmpDir . '/build/js/index.js';
        file_put_contents($js_path, '// js');
        file_put_contents(
            $this->tmpDir . '/build/js/index.asset.php',
            '<?php return ["dependencies" => ["wp-dom-ready", "wp-i18n"], "version" => "abc123"];'
        );

        $sut = $this->makeInstance();
        $result = $sut->resolve('build/js/index.js');

        self::assertSame('abc123', $result['version'], '');
        self::assertSame(['wp-dom-ready', 'wp-i18n'], $result['dependencies'], '');
        unlink($this->tmpDir . '/build/js/index.asset.php');
    }

    public function testItReturnsEmptyDepsAndNullVersionWhenFileNotFound(): void
    {
        $sut = $this->makeInstance();
        $result = $sut->resolve('build/js/nonexistent.js');

        self::assertSame([], $result['dependencies'], '');
        self::assertNull($result['version'], '');
        self::assertStringContainsString('build/js/nonexistent.js', $result['url'], '');
    }

    public function testItFallsBackToMtimeWhenAssetPhpIsAbsent(): void
    {
        $js_path = $this->tmpDir . '/build/js/index.js';
        file_put_contents($js_path, '// js');

        $sut = $this->makeInstance();
        $result = $sut->resolve('build/js/index.js');

        self::assertSame((string) filemtime($js_path), $result['version'], '');
    }
}
