<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\UI\Components\Posts;

use ItalyStrap\Tests\Shared\UI\Components\IsDisplayableTestTrait;
use ItalyStrap\Tests\Unit\UI\Components\CommonRenderViewBlockTestTrait;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Posts\Posts;
use Prophecy\Argument;

class PostsTest extends UnitTestCase
{
    use IsDisplayableTestTrait;
    use CommonRenderViewBlockTestTrait;

    protected function makeInstance(): Posts
    {
        $sut = new Posts($this->makeViewBlock(), $this->makeDispatcher());
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    public function testItShouldRender()
    {
        $sut = $this->makeInstance();

        $this->viewBlock->render($sut::TEMPLATE_NAME, Argument::type('array'))->willReturn($sut::TEMPLATE_NAME);

        $this->tester->assertRenderableEventIsChanged($sut, $sut::TEMPLATE_NAME);
    }
}
