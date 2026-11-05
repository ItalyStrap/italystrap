<?php

declare(strict_types=1);

namespace ItalyStrap\Assets\Infrastructure;

use ItalyStrap\Asset\BuildMetadata;
use ItalyStrap\Asset\BuildMetadataFile;
use ItalyStrap\Asset\Dependencies;
use ItalyStrap\Asset\FixedVersion;
use ItalyStrap\Asset\FolderUrls;
use ItalyStrap\Asset\NoVersion;
use ItalyStrap\Asset\Version;
use SplFileInfo;

/**
 * A file of the theme, the child theme first, with its URL, its dependencies and its version.
 *
 * The dependencies and the version come from the .asset.php file of the build, the version is
 * the time of the file without it. A missing file, before the build, has the URL of the parent theme.
 */
final readonly class ThemeFile
{
    private string $path;

    /**
     * @param string $path Relative to the theme folder, like build/js/index.js.
     */
    public function __construct(
        string $path,
        private ThemeFolders $folders = new ThemeFolders(),
    ) {
        $this->path = \ltrim($path, '/');
    }

    public function url(): string
    {
        $file = $this->file();
        if ($file instanceof SplFileInfo) {
            return (new FolderUrls($this->folders->toArray()))->url($file);
        }

        $urls = $this->folders->toArray();

        return \end($urls) . '/' . $this->path;
    }

    public function dependencies(): Dependencies
    {
        return $this->metadata()?->dependencies() ?? new Dependencies();
    }

    public function version(): Version
    {
        $metadata = $this->metadata();
        if ($metadata instanceof BuildMetadata) {
            return $metadata->version();
        }

        $file = $this->file();

        return $file instanceof SplFileInfo ? new FixedVersion((string) $file->getMTime()) : new NoVersion();
    }

    private function metadata(): ?BuildMetadata
    {
        $file = $this->file();
        if (!$file instanceof SplFileInfo) {
            return null;
        }

        $metadata = new BuildMetadataFile($file);

        return $metadata->exists() ? $metadata->read() : null;
    }

    private function file(): ?SplFileInfo
    {
        foreach (\array_keys($this->folders->toArray()) as $folder) {
            $file = new SplFileInfo($folder . '/' . $this->path);
            if ($file->isFile()) {
                return $file;
            }
        }

        return null;
    }
}
