<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Integration\Theme;

use ItalyStrap\Tests\IntegrationTestCase;
use ItalyStrap\Theme\NavMenusSubscriber;
use ItalyStrap\Theme\Registrable;

use function add_filter;
use function has_nav_menu;

class NavMenus extends IntegrationTestCase
{
    protected function getInstance(): NavMenusSubscriber
    {
        $sut = new NavMenusSubscriber($this->getConfig());
        $this->assertInstanceOf(Registrable::class, $sut, '');
        $this->assertInstanceOf(NavMenusSubscriber::class, $sut, '');
        return $sut;
    }

    /**
     * @test
     */
    public function itShouldRegister()
    {
        $should_load = 0;
        add_filter('theme_mod_nav_menu_locations', function ($default) use (&$should_load) {
            $should_load++;
            return [
                'new-menu'          => __('Main Menu', 'italystrap'),
            ];
        });

        $this->config->toArray()->willReturn([
            'new-menu'          => __('Main Menu', 'italystrap'),
        ])->shouldBeCalled(1);

        $sut = $this->getInstance();
        $sut->register();

        $this->assertTrue(has_nav_menu('new-menu'), '');
        $this->assertTrue(\boolval($should_load), '');
    }
}
