<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\UI\Components\Sidebars;

use ItalyStrap\Tests\Unit\UI\Components\CommonRenderViewBlockTestTrait;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Sidebars\Sidebar;

class SidebarTest extends UnitTestCase
{
    use CommonRenderViewBlockTestTrait;

    protected function makeInstance(): Sidebar
    {
        $sut = new Sidebar(
            $this->makeConfig(),
            $this->makeViewBlock(),
            $this->makeDispatcher()
        );
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    public function testItShouldLoad()
    {
        $this->defineFunction('is_active_sidebar', fn() => true);
        $this->config->get('site_layout')->willReturn('is-not-full-with');

        $sut = $this->makeInstance();
        $this->assertTrue($sut->shouldDisplay(), '');
    }
}
