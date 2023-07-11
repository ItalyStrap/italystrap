<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\WPUnit\Theme;

use ItalyStrap\Tests\WPTestCase;

class SupportSubscriberTest extends WPTestCase
{
    protected function getInstance($paramConfig = [])
    {
        $support = new \ItalyStrap\Theme\Support();
        $config = \ItalyStrap\Config\ConfigFactory::make($paramConfig);
        $sut = new \ItalyStrap\Theme\SupportSubscriber($config, $support);
        $this->assertInstanceOf(\ItalyStrap\Theme\Registrable::class, $sut, '');
        $this->assertInstanceOf(\ItalyStrap\Theme\SupportSubscriber::class, $sut, '');
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
