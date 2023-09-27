<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Components;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Components\Sidebar;
use ItalyStrap\Tests\UnitTestCase;
use Prophecy\Argument;

class SidebarTest extends UnitTestCase
{
    protected function getInstance(): Sidebar
    {
        $sut = new Sidebar($this->makeConfig(), $this->makeView());
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    /**
     * @test
     */
    public function itShouldLoad()
    {

        $this->config->get('site_layout')->willReturn('some-value');

        $sut = $this->getInstance();
        $this->assertTrue($sut->shouldDisplay(), '');
    }

    /**
     * @test
     */
    public function itShouldDisplay()
    {
        $sut = $this->getInstance();

        $this->view->render('sidebar', Argument::type('array'))->willReturn('sidebar');

        $this->expectOutputString('sidebar');
        $sut->display();
    }
}
