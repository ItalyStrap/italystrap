<?php

declare(strict_types=1);

namespace ItalyStrap\Theme\Infrastructure;

interface ImageSizeInterface
{
    /**
     * @param string $name
     * @param int $width
     * @param int $height
     * @param bool|array{0: string, 1: string} $crop True to crop from the center, or the x and y
     *                                              positions, like ['center', 'top'].
     * @return void
     */
    public function addSize(string $name, int $width = 0, int $height = 0, $crop = false);

    /**
     * @param string $name
     * @return void
     */
    public function removeSize(string $name);

    /**
     * @param string $name
     * @return bool
     */
    public function hasSize(string $name);
}
