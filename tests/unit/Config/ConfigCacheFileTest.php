<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Config;

use ItalyStrap\Config\ConfigCacheFile;
use ItalyStrap\Tests\UnitTestCase;

class ConfigCacheFileTest extends UnitTestCase
{
    private string $directory;

    // phpcs:ignore
    protected function _before()
    {
        parent::_before();
        $this->directory = codecept_output_dir('config-cache');
        if (!\is_dir($this->directory)) {
            \mkdir($this->directory);
        }

        foreach (\glob($this->directory . '/*.php') ?: [] as $file) {
            \unlink($file);
        }
    }

    private function makeInstance(string $versions): ConfigCacheFile
    {
        return new ConfigCacheFile($this->directory, 'mikiko', $versions);
    }

    private function touch(string $name): string
    {
        $file = $this->directory . '/' . $name;
        \file_put_contents($file, '<?php return [];');
        return $file;
    }

    public function testItShouldChangeThePathWithTheVersions(): void
    {
        $this->assertNotSame(
            $this->makeInstance('4.0.0|3.0.1')->path(),
            $this->makeInstance('4.0.0|3.0.2')->path()
        );
        $this->assertMatchesRegularExpression(
            '#/config-cache-mikiko-[0-9a-f]{8}\.php$#',
            $this->makeInstance('4.0.0|3.0.2')->path()
        );
    }

    public function testItShouldRemoveTheFilesOfOtherVersionsAndTheUnversionedFile(): void
    {
        $old = $this->touch(\basename($this->makeInstance('4.0.0|3.0.1')->path()));
        $unversioned = $this->touch('config-cache-mikiko.php');

        $this->makeInstance('4.0.0|3.0.2')->removeStale();

        $this->assertFileDoesNotExist($old);
        $this->assertFileDoesNotExist($unversioned);
    }

    public function testItShouldKeepOtherKeysAndTheCurrentFile(): void
    {
        $other = $this->touch('config-cache-mikiko-qa-' . \substr(\md5('x'), 0, 8) . '.php');
        $current = $this->touch(\basename($this->makeInstance('4.0.0|3.0.2')->path()));
        $old = $this->touch(\basename($this->makeInstance('4.0.0|3.0.1')->path()));

        $this->makeInstance('4.0.0|3.0.2')->removeStale();

        $this->assertFileExists($other);
        $this->assertFileExists($current);
        // The current file exists, so nothing is cleaned until the next version.
        $this->assertFileExists($old);
    }
}
