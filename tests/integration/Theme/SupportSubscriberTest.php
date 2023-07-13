<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Integration\Theme;

use ItalyStrap\Config\ConfigFactory;
use ItalyStrap\Tests\IntegrationTestCase;
use ItalyStrap\Theme\Registrable;
use ItalyStrap\Theme\Support;
use ItalyStrap\Theme\SupportSubscriber;

class SupportSubscriberTest extends IntegrationTestCase
{
    protected function getInstance($paramConfig = [])
    {
        $support = new Support();
        $config = ConfigFactory::make($paramConfig);
        $sut = new SupportSubscriber($config, $support);
        $this->assertInstanceOf(Registrable::class, $sut, '');
        $this->assertInstanceOf(SupportSubscriber::class, $sut, '');
        return $sut;
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

//        $sut = $this->getInstance($support);
//
//        $sut->register();
//
//        $this->assertEqualSets([$support['html5']], \get_theme_support('html5'));
    }
}
