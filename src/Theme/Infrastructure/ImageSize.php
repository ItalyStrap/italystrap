<?php

declare(strict_types=1);

namespace ItalyStrap\Theme\Infrastructure;

class ImageSize implements ImageSizeInterface
{
    /**
     * @inheritDoc
     */
    public function addSize(string $name, int $width = 0, int $height = 0, bool $crop = false): void
    {
        \add_image_size(...func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function removeSize(string $name): void
    {
        \remove_image_size($name);
    }

    /**
     * @inheritDoc
     */
    public function hasSize(string $name): bool
    {
        return \has_image_size($name);
    }
}
