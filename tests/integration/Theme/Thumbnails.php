<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Integration\Theme;

use ItalyStrap\Config\ConfigFactory;
use ItalyStrap\Tests\IntegrationTestCase;
use ItalyStrap\Theme\ThumbnailsSubscriber;
use PHPUnit\Framework\Assert;

// phpcs:disable
require_once 'BaseTheme.php';
// phpcs:enable

class Thumbnails extends IntegrationTestCase
{
    protected function getInstance($paramConfig = []): ThumbnailsSubscriber
    {
        $config = ConfigFactory::make($paramConfig);
        return new ThumbnailsSubscriber($config);
    }

    public function itShouldRegister()
    {
        $support = [
            'sizes' => [
                'navbar-brand-image'    => [
                    ThumbnailsSubscriber::WIDTH   => 45,
                    ThumbnailsSubscriber::HEIGHT  => 45,
                    ThumbnailsSubscriber::CROP        => true,
                ],
            ],
        ];

        $sut = $this->getInstance($support);

        $sut();

        Assert::assertTrue(\has_image_size('navbar-brand-image'), '');
    }
}
