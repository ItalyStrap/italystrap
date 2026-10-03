<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\UI\Components\Footer;

use ItalyStrap\Tests\Shared\UI\Components\IsDisplayableTestTrait;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Footer\Colophon;
use Prophecy\Argument;

class ColophonTest extends UnitTestCase
{
    use IsDisplayableTestTrait;

    protected function makeInstance(): Colophon
    {
        $sut = new Colophon($this->makeConfig(), $this->makeViewBlock());
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    public function testItShouldRender()
    {
        $sut = $this->makeInstance();

        $this->config->get('colophon', '')->willReturn($sut::TEMPLATE_NAME);

        $this->viewBlock->render($sut::TEMPLATE_NAME, Argument::type('array'))->willReturn($sut::TEMPLATE_NAME);

        $this->tester->assertRenderableEventIsChanged($sut, $sut::TEMPLATE_NAME);
    }
}
