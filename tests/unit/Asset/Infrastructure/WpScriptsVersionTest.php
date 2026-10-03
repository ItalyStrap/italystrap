<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Asset\Infrastructure;

use ItalyStrap\Asset\Infrastructure\WpScriptsVersion;
use ItalyStrap\Tests\UnitTestCase;
use SplFileInfo;

class WpScriptsVersionTest extends UnitTestCase
{
    private string $tmpDir;

    protected function _before(): void
    {
        parent::_before();
        $this->tmpDir = sys_get_temp_dir() . '/italystrap-wp-scripts-version-test-' . uniqid();
        mkdir($this->tmpDir, 0777, true);
    }

    protected function _after(): void
    {
        parent::_after();
        array_map('unlink', glob($this->tmpDir . '/*') ?: []);
        rmdir($this->tmpDir);
    }

    private function makeInstance(): WpScriptsVersion
    {
        return new WpScriptsVersion();
    }

    public function testItReturnsVersionFromAssetPhpWhenPresent(): void
    {
        $js_path = $this->tmpDir . '/index.js';
        file_put_contents($js_path, '// js');
        file_put_contents(
            $this->tmpDir . '/index.asset.php',
            '<?php return ["dependencies" => ["wp-dom-ready"], "version" => "abc123def456"];'
        );

        $sut = $this->makeInstance();
        $result = $sut->version(new SplFileInfo($js_path), []);

        self::assertSame('abc123def456', $result, '');
    }

    public function testItFallsBackToMtimeWhenAssetPhpIsAbsent(): void
    {
        $js_path = $this->tmpDir . '/index.js';
        file_put_contents($js_path, '// js');
        $mtime = (string) filemtime($js_path);

        $sut = $this->makeInstance();
        $result = $sut->version(new SplFileInfo($js_path), []);

        self::assertSame($mtime, $result, '');
    }

    public function testItFallsBackToMtimeWhenAssetPhpHasNoVersion(): void
    {
        $js_path = $this->tmpDir . '/index.js';
        file_put_contents($js_path, '// js');
        file_put_contents(
            $this->tmpDir . '/index.asset.php',
            '<?php return ["dependencies" => ["wp-dom-ready"]];'
        );
        $mtime = (string) filemtime($js_path);

        $sut = $this->makeInstance();
        $result = $sut->version(new SplFileInfo($js_path), []);

        self::assertSame($mtime, $result, '');
    }

    public function testItFallsBackToMtimeWhenAssetPhpIsNotAnArray(): void
    {
        $js_path = $this->tmpDir . '/index.js';
        file_put_contents($js_path, '// js');
        file_put_contents($this->tmpDir . '/index.asset.php', '<?php return null;');
        $mtime = (string) filemtime($js_path);

        $sut = $this->makeInstance();
        $result = $sut->version(new SplFileInfo($js_path), []);

        self::assertSame($mtime, $result, '');
    }
}
