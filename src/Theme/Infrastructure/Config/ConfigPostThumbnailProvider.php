<?php

declare(strict_types=1);

namespace ItalyStrap\Theme\Infrastructure\Config;

use ItalyStrap\Config\AlignmentKeys;
use ItalyStrap\Theme\Application\ThumbnailsSubscriber;

class ConfigPostThumbnailProvider
{
    public const POST_THUMBNAIL_SIZE = 'post_thumbnail_size';
    public const POST_THUMBNAIL_ALIGNMENT = 'post_thumbnail_alignment';
    public const POST_CONTENT_WIDTH = 'content_width';

    public const POST_THUMBNAIL_SIZE_DEFAULT = 'post-thumbnail';

    public const POST_THUMBNAIL_ID_DEFAULT = 'default_image';

    public const WIDTH = 'width';
    public const HEIGHT = 'height';
    public const CROP = 'crop';

    public function __invoke(): iterable
    {

        $container = 1170;
        $gutter = 30;

        yield self::POST_THUMBNAIL_SIZE => self::POST_THUMBNAIL_SIZE_DEFAULT;
        yield self::POST_THUMBNAIL_ALIGNMENT => AlignmentKeys::ALIGN_FULL;
        yield self::POST_CONTENT_WIDTH => $this->getContentWidth(
            1170,
            12,
            8,
            30
        );

        yield ThumbnailsSubscriber::class => [
            'navbar-brand-image'    => [
                self::WIDTH => 45,
                self::HEIGHT    => 45,
                self::CROP      => true,
            ],

            /**
             * La full-width serve solo per la pagina omonima
             * Si potrebbe invece settare "large" a 1140 (verificare se 1170 va bene) e risparmiare
             * spazio avendo una immagine di meno poichè entrambe non vengono croppate
             * "large" può essere settata anche con altezza a 9999
             */
            'full-width'            => [
                self::WIDTH => $container - $gutter,
                self::HEIGHT    => 9999,
                self::CROP      => false,
            ],
            'one_half'          => [
                self::WIDTH => $container / 2 - $gutter,
                self::HEIGHT    => ($container / 2 - $gutter) * 3 / 4,
                self::CROP      => true,
            ],
            'one_third'         => [
                self::WIDTH => $container / 3 - $gutter,
                self::HEIGHT    => ($container / 3 - $gutter) * 3 / 4,
                self::CROP      => true,
            ],
            'one_fourth'            => [
                self::WIDTH => $container / 4 - $gutter,
                self::HEIGHT    => ($container / 4 - $gutter) * 3 / 4,
                self::CROP      => true,
            ],
            'one_six'           => [
                self::WIDTH => $container / 6 - $gutter,
                self::HEIGHT    => ($container / 6 - $gutter) * 3 / 4,
                self::CROP      => true,
            ],
        ];
    }

    /**
     * Get the content width
     *
     * @param int $container_width
     * @param int $column
     * @param int $content_column_width
     * @param int $gutter
     * @return int [description]
     */
    private function getContentWidth(
        int $container_width,
        int $column,
        int $content_column_width,
        int $gutter = 0
    ): int {
        return intval($container_width / $column * $content_column_width - $gutter);
    }
}
