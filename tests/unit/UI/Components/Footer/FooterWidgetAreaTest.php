<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\UI\Components\Footer;

use ItalyStrap\Tests\Shared\UI\Components\IsDisplayableTestTrait;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Footer\FooterWidgetArea;
use Prophecy\Argument;

class FooterWidgetAreaTest extends UnitTestCase
{
    use IsDisplayableTestTrait;

    protected function makeInstance(): FooterWidgetArea
    {
        $sut = new FooterWidgetArea($this->makeViewBlock());
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    public function testItShouldDisplay()
    {
        $sut = $this->makeInstance();

        $this->config->toArray()->willReturn([]);

        $this->viewBlock->render($sut::TEMPLATE_NAME, Argument::type('array'))->willReturn($sut::TEMPLATE_NAME);

        $this->tester->assertRenderableEventIsChanged($sut, $sut::TEMPLATE_NAME);
    }
}
