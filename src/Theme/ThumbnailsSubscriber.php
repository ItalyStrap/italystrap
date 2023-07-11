<?php

declare(strict_types=1);

namespace ItalyStrap\Theme;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Config\ConfigPostThumbnailProvider;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\StdLib\Media\ImageSizeInterface;

use function array_merge;
use function array_walk;
use function intval;
use function set_post_thumbnail_size;

final class ThumbnailsSubscriber implements Registrable, SubscriberInterface
{
    public const WIDTH = 'width';
    public const HEIGHT = 'height';
    public const CROP = 'crop';
    private ConfigInterface $config;
    private ImageSizeInterface $image_sizes_obj;

    /**
     * @inheritDoc
     */
    public function getSubscribedEvents(): iterable
    {
        yield 'italystrap_theme_load'   => [
            static::CALLBACK    => self::REGISTER_CB,
            static::PRIORITY    => 20,
        ];
    }


    public function __construct(ConfigInterface $config, ImageSizeInterface $image_sizes)
    {
        $this->config = $config;
        $this->image_sizes_obj = $image_sizes;
    }

    /**
     * Register image size
     *
     * thumbnail_size_w
     * thumbnail_size_h
     * thumbnail_crop
     * medium_size_h: The medium size height.
     * medium_size_w: The medium size width.
     * large_size_h: The large size height.
     * large_size_w: The large size width.
     *
     * @example update_option( 'large_size_h', 700 );
     * @example
     *  add_image_size(
     *      'medium',
     *      get_option( 'medium_size_w' ),
     *      get_option( 'medium_size_h' ),
     *      true
     * ); // For cropping the default image size.

     * Maybe first remove_image_size and then add_image_size it's better
     *
     * @link https://developer.wordpress.org/reference/functions/add_image_size/
     * @link http://wordpress.stackexchange.com/questions/30965/set-default-image-sizes-in-wordpress-to-hard-crop
     *
     * @return void
     */
    public function register(): void
    {

        /**
         * $content_width is a global variable used by WordPress for max image upload sizes
         * and media embeds (in pixels).
         *
         * Example: If the content area is 640px wide,
         * set $content_width = 620; so images and videos will not overflow.
         * Default: 750px is the default ItalyStrap container width.
         */
        global $content_width;
        if (! isset($content_width)) {
            $content_width = (string)$this->config->get(ConfigPostThumbnailProvider::POST_CONTENT_WIDTH, '750');
        }

        /**
         * 'post-thumbnails' is by default the size displayed for posts, pages and all archives.
         */
        set_post_thumbnail_size($content_width, intval($content_width * 3 / 4));

        $sizes = (array)$this->config->get(self::class, []);
        array_walk($sizes, function (array $params, string $name): void {
            $params = array_merge($this->getDefaultImageParams(), $params);

            $this->image_sizes_obj->addSize(
                $name,
                (int)$params[ ConfigPostThumbnailProvider::WIDTH ],
                (int)$params[ ConfigPostThumbnailProvider::HEIGHT ],
                (bool)$params[ ConfigPostThumbnailProvider::CROP ] ?? false
            );
        });
    }

    private function getDefaultImageParams(): array
    {
        return [
            ConfigPostThumbnailProvider::WIDTH => 0,
            ConfigPostThumbnailProvider::HEIGHT => 0,
            ConfigPostThumbnailProvider::CROP => false,
        ];
    }
}
