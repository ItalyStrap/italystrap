<?php

declare(strict_types=1);

namespace ItalyStrap\Cache;

/**
 * The cache file of the aggregated config, one per theme and site.
 *
 * The fingerprint changes with the theme versions, so a release reads a new file and never
 * a config cached by the previous code. The files of older fingerprints are removed.
 */
final class ConfigCacheFile
{
    private const PREFIX = 'config-cache-';
    private const FINGERPRINT_LENGTH = 8;

    public function __construct(
        private string $directory,
        private string $key,
        private string $versions
    ) {
    }

    public function path(): string
    {
        return $this->directory . '/' . self::PREFIX . $this->key . '-' . $this->fingerprint() . '.php';
    }

    /**
     * Deletes the files of the same key cached with other versions, before the new one is written.
     */
    public function removeStale(): void
    {
        if (\is_file($this->path())) {
            return;
        }

        foreach ($this->staleFiles() as $file) {
            \unlink($file);
        }
    }

    /**
     * @return list<string>
     */
    private function staleFiles(): array
    {
        $base = $this->directory . '/' . self::PREFIX . $this->key;
        $hex = \str_repeat('[0-9a-f]', self::FINGERPRINT_LENGTH);

        // The exact fingerprint length keeps another key with the same prefix, like "theme-qa", out of the match.
        return \array_values(\array_filter(
            [...(\glob($base . '-' . $hex . '.php') ?: []), $base . '.php'],
            'is_file'
        ));
    }

    private function fingerprint(): string
    {
        return \substr(\md5($this->versions), 0, self::FINGERPRINT_LENGTH);
    }
}
