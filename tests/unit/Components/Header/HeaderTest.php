<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Components\Header;

use ItalyStrap\Components\Header\Header;
use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Tests\UnitTestCase;
use Prophecy\Argument;

class HeaderTest extends UnitTestCase
{
    protected function getInstance(): Header
    {
        $sut = new Header($this->getConfig(), $this->getView(), $this->makeGlobalDispatcher(), $this->getTag());
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    /**
     * @test
     */
    public function itShouldLoad()
    {
        $sut = $this->getInstance();
        $this->assertTrue($sut->shouldDisplay(), '');
    }

    /**
     * @test
     */
    public function itShouldDisplay()
    {
        $sut = $this->getInstance();

        $this->config->get('current_template_slug')->willReturn('');

        $this->defineFunction('get_body_class', static fn(): array => [
                'class-1',
                'class-2',
            ]);

        $this->view->render(Header::VIEW, Argument::type('array'))->willReturn('header');

        $this->expectOutputString('header');
        $sut->display();
    }
}
