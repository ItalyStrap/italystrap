<?php

declare(strict_types=1);

namespace ItalyStrap\Theme\Infrastructure\Config;

use ItalyStrap\Theme\Application\PostTypeSupportSubscriber;

class ConfigPostTypeSupportProvider
{
    public function __invoke(): iterable
    {
        return [
            PostTypeSupportSubscriber::class =>     [
                'post'      => [ 'post_navigation', 'entry-meta' ],
                'page'      => [ 'post_navigation', 'entry-meta' ],
                'download'  => [ 'post_navigation', 'entry-meta' ],
            ],
        ];
    }
}
