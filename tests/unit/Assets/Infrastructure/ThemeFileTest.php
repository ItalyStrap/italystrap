<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Assets\Infrastructure;

use Codeception\Test\Unit;
use ItalyStrap\Asset\FixedVersion;
use ItalyStrap\Asset\NoVersion;
use ItalyStrap\Assets\Infrastructure\ThemeFile;
use ItalyStrap\Assets\Infrastructure\ThemeFolders;

class ThemeFileTest extends Unit
{
    private const CHILD_URL = 'http://test/wp-content/themes/child';
    private const PARENT_URL = 'http://test/wp-content/themes/italystrap';

    private string $root;

    // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore -- Codeception method
    protected function _before(): void
    {
        $this->root = \sys_get_temp_dir() . '/italystrap-theme-file-test-' . \uniqid();
        \mkdir($this->root . '/child/build/js', 0777, true);
        \mkdir($this->root . '/parent/build/js', 0777, true);
    }

    // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore -- Codeception method
    protected function _after(): void
    {
        foreach (['child', 'parent'] as $theme) {
            \array_map('unlink', \glob($this->root . '/' . $theme . '/build/js/*') ?: []);
            \rmdir($this->root . '/' . $theme . '/build/js');
            \rmdir($this->root . '/' . $theme . '/build');
            \rmdir($this->root . '/' . $theme);
        }

        \rmdir($this->root);
    }

    public function testTheChildThemeFileWins(): void
    {
        $this->write('child/build/js/index.js');
        $this->write('parent/build/js/index.js');

        $this->assertSame(self::CHILD_URL . '/build/js/index.js', $this->file('build/js/index.js')->url());
    }

    public function testTheParentThemeFileIsTheFallback(): void
    {
        $this->write('parent/build/js/index.js');

        $this->assertSame(self::PARENT_URL . '/build/js/index.js', $this->file('build/js/index.js')->url());
    }

    public function testItReadsTheBuildMetadata(): void
    {
        $this->write('parent/build/js/index.js');
        $this->write(
            'parent/build/js/index.asset.php',
            "<?php return ['dependencies' => ['wp-dom-ready', 'wp-i18n'], 'version' => 'abc123'];"
        );

        $file = $this->file('build/js/index.js');

        $this->assertSame(['wp-dom-ready', 'wp-i18n'], $file->dependencies()->toArray());
        $this->assertSame('abc123', $file->version()->value());
    }

    public function testWithoutBuildMetadataTheVersionIsTheTimeOfTheFile(): void
    {
        $this->write('parent/build/js/index.js');
        \touch($this->root . '/parent/build/js/index.js', 1700000000);

        $file = $this->file('build/js/index.js');

        $this->assertSame([], $file->dependencies()->toArray());
        $this->assertInstanceOf(FixedVersion::class, $file->version());
        $this->assertSame('1700000000', $file->version()->value());
    }

    public function testAMissingFileHasTheUrlOfTheParentThemeAndNoVersion(): void
    {
        $file = $this->file('build/js/missing.js');

        $this->assertSame(self::PARENT_URL . '/build/js/missing.js', $file->url());
        $this->assertSame([], $file->dependencies()->toArray());
        $this->assertInstanceOf(NoVersion::class, $file->version());
    }

    public function testTheLeadingSlashOfThePathIsIgnored(): void
    {
        $this->write('parent/build/js/index.js');

        $this->assertSame(self::PARENT_URL . '/build/js/index.js', $this->file('/build/js/index.js')->url());
    }

    public function testTheFoldersMakeTheFiles(): void
    {
        $this->write('child/build/js/index.js');

        $this->assertSame(self::CHILD_URL . '/build/js/index.js', $this->folders()->file('build/js/index.js')->url());
    }

    private function file(string $path): ThemeFile
    {
        return new ThemeFile($path, $this->folders());
    }

    private function folders(): ThemeFolders
    {
        return new ThemeFolders([
            $this->root . '/child' => self::CHILD_URL,
            $this->root . '/parent' => self::PARENT_URL,
        ]);
    }

    private function write(string $name, string $content = '// js'): void
    {
        \file_put_contents($this->root . '/' . $name, $content);
    }
}
