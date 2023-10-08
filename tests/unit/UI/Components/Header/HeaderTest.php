<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\UI\Components\Header;

use ItalyStrap\Tests\Shared\UI\Components\IsDisplayableTestTrait;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Header\Header;
use Prophecy\Argument;

class HeaderTest extends UnitTestCase
{
    use IsDisplayableTestTrait;

    protected function makeInstance(): Header
    {
        $sut = new Header(
            $this->makeView(),
            $this->makeDispatcher(),
            $this->makeTag()
        );
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    public function testItShouldRender()
    {
        $sut = $this->makeInstance();

        $this->config->get('current_template_slug')->willReturn('');

        $this->defineFunction('get_body_class', static fn(): array => [
                'class-1',
                'class-2',
            ]);

        $this->view->render(Header::TEMPLATE_NAME, Argument::type('array'))->willReturn('header');

        $this->tester->assertRenderableEventIsChanged($sut, 'header');
    }
}
