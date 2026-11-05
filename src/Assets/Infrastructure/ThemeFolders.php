<?php

declare(strict_types=1);

namespace ItalyStrap\Assets\Infrastructure;

/**
 * The folders of the child theme and of its parent with their URLs, the child first.
 */
final readonly class ThemeFolders
{
    /**
     * @param array<string, string>|null $folders The paths and their URLs, null for the active theme.
     */
    public function __construct(
        private ?array $folders = null,
    ) {
    }

    public function file(string $path): ThemeFile
    {
        return new ThemeFile($path, $this);
    }

    /**
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return $this->folders ?? [
            \get_stylesheet_directory() => \get_stylesheet_directory_uri(),
            \get_template_directory() => \get_template_directory_uri(),
        ];
    }
}
