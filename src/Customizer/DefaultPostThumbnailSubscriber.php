<?php

declare(strict_types=1);

namespace ItalyStrap\Customizer;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Theme\Infrastructure\Config\ConfigPostThumbnailProvider;

final class DefaultPostThumbnailSubscriber implements SubscriberInterface
{
    private ConfigInterface $config;

    public function getSubscribedEvents(): iterable
    {
        yield 'post_thumbnail_id'   => [
            SubscriberInterface::CALLBACK   => '__invoke',
        ];
    }

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * @param int|false $thumbnail_id
     * @return int
     */
    public function __invoke($thumbnail_id): int
    {
        $thumbnail_id = (int)$thumbnail_id;

        if (empty($thumbnail_id)) {
            return (int)$this->config->get(ConfigPostThumbnailProvider::POST_THUMBNAIL_ID_DEFAULT, 0);
        }

        return $thumbnail_id;
    }
}
