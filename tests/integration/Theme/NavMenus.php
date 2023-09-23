<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Integration\Theme;

use ItalyStrap\Tests\IntegrationTestCase;
use ItalyStrap\Theme\NavMenusSubscriber;
use PHPUnit\Framework\Assert;

use function add_filter;
use function boolval;
use function has_nav_menu;

class NavMenus extends IntegrationTestCase
{
    protected function getInstance(): NavMenusSubscriber
    {
        $sut = new NavMenusSubscriber($this->getConfig());
        Assert::assertInstanceOf(NavMenusSubscriber::class, $sut, '');
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
                'new-menu' => __('Main Menu', 'italystrap'),
            ];
        });

        $this->config->toArray()->willReturn([
            'new-menu' => __('Main Menu', 'italystrap'),
        ])->shouldBeCalled(1);

        $sut = $this->getInstance();
        $sut();

        Assert::assertTrue(has_nav_menu('new-menu'), '');
        Assert::assertTrue(boolval($should_load), '');
    }
}
