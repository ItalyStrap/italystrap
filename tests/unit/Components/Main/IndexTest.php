<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Components\Main;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Components\Main\Index;
use ItalyStrap\Tests\UnitTestCase;
use PHPUnit\Framework\Assert;
use Prophecy\Argument;

class IndexTest extends UnitTestCase
{
    protected function makeInstance(): Index
    {
        $sut = new Index(
            $this->makeConfig(),
            $this->makeViewBlock(),
            $this->makeDispatcher()
        );
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    public function testItShouldLoad()
    {
        $sut = $this->makeInstance();
        $this->assertTrue($sut->shouldDisplay(), '');
    }

    public function testItShouldRender()
    {
        $sut = $this->makeInstance();

        $this->viewBlock->render(Index::TEMPLATE_NAME, Argument::type('array'))->willReturn('index');

        $this->tester->assertRenderableEventIsChanged($sut, 'index');
    }
}
