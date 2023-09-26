<?php

declare(strict_types=1);

namespace ItalyStrap\Customizer;

use ItalyStrap\Theme\Application\ThumbnailsSubscriber;
use ItalyStrap\Theme\Infrastructure\Config\ConfigPostThumbnailProvider;

trait BuildThumbnailSizeChoicesTrait
{
    private function buildSizeChoices()
    {
        $size_choices = $this->dispatcher->filter('image_size_names_choose', [
            '' => \__('Select dimension', 'italystrap'),
        ]);

        foreach ($this->config->get(ThumbnailsSubscriber::class) as $name => $size) {
            $size_choices[$name] = \sprintf(
                '%s %sx%spx',
                $name,
                $size[ ConfigPostThumbnailProvider::WIDTH ],
                $size[ ConfigPostThumbnailProvider::HEIGHT ]
            );
        }

        return $size_choices;
    }
}
