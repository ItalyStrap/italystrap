<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\UI\Components;

use Prophecy\Argument;

trait CommonRenderViewBlockTestTrait
{
    public function testItShouldRenderWithViewBlockFromCommonTrait()
    {
        $sut = $this->makeInstance();

        $this->viewBlock->render($sut::TEMPLATE_NAME, Argument::type('array'))->willReturn($sut::TEMPLATE_NAME);
        $this->view->render($sut::TEMPLATE_NAME, Argument::type('array'))->willReturn($sut::TEMPLATE_NAME);

        $this->tester->assertRenderableEventIsChanged($sut, $sut::TEMPLATE_NAME);
    }
}
