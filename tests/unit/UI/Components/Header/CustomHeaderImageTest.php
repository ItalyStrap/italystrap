<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\UI\Components\Header;

use ItalyStrap\Config\ConfigCustomHeaderProvider;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Header\CustomHeaderImage;
use ItalyStrap\UI\Elements\Figure;
use Prophecy\Argument;

class CustomHeaderImageTest extends UnitTestCase
{
    protected function getInstance(): CustomHeaderImage
    {
        $sut = new CustomHeaderImage(
            $this->makeConfig(),
            $this->makeViewBlock(),
            $this->makeTag(),
            new Figure($this->makeViewBlock(), $this->makeTag())
        );
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    public function testItShouldLoad()
    {

        $this->defineFunction('has_header_image', static fn() => true);

        $sut = $this->getInstance();
        $this->assertTrue($sut->shouldDisplay(), '');
    }

    public function testItShouldDisplay()
    {
        $sut = $this->getInstance();

        /** printFigureContainer */
        $this->viewBlock->render(Figure::TEMPLATE_NAME, Argument::type('array'))->willReturn(Figure::TEMPLATE_NAME);
        $this->defineFunction('get_header_image_tag', fn() => 'Image tag content');
        $this->config->get(ConfigCustomHeaderProvider::CUSTOM_HEADER_ALIGNMENT)->willReturn('');
        /** end printFigureContainer */

        $this->viewBlock->render($sut::TEMPLATE_NAME, Argument::type('array'))->willReturn($sut::TEMPLATE_NAME);

        $this->tester->assertRenderableEventIsChanged($sut, $sut::TEMPLATE_NAME);
    }
}
