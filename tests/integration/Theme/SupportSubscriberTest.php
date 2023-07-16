<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Integration\Theme;

use ItalyStrap\Config\ConfigFactory;
use ItalyStrap\Tests\IntegrationTestCase;
use ItalyStrap\Theme\Registrable;
use ItalyStrap\Theme\Support;
use ItalyStrap\Theme\SupportSubscriber;

use function ItalyStrap\Factory\injector;

class SupportSubscriberTest extends IntegrationTestCase
{
    protected function getInstance($paramConfig = []): SupportSubscriber
    {
        $config = ConfigFactory::make($paramConfig);
        codecept_debug($config->get(SupportSubscriber::class));
        return injector()->make(SupportSubscriber::class, [
            ':config' => $config,
        ]);
    }

    /**
     * @test
     */
    public function itShouldRegister()
    {
        $support = [
            'automatic-feed-links',
            'html5' => [
                'comment-form',
                'comment-list',
                'search-form',
                'gallery',
                'caption',
                'style',
                'script',
            ],
        ];

        $sut = $this->getInstance($support);

        $sut->register();

        codecept_debug(\get_theme_support('html5'));

//        $this->assertEqualSets([$support['html5']], \get_theme_support('html5'));
    }
}
