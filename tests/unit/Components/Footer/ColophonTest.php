<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Components;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Components\Footer\Colophon;
use ItalyStrap\Tests\UnitTestCase;
use PHPUnit\Framework\Assert;
use Prophecy\Argument;

class ColophonTest extends UnitTestCase
{
    protected function getInstance(): Colophon
    {
        $sut = new Colophon($this->getConfig(), $this->getView(), $this->makeGlobalDispatcher());
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

        $this->config->get('colophon', '')->willReturn('footers/colophon');

        $this->globalDispatcher->filter(
            'italystrap_colophon_output',
            'footers/colophon'
        )->shouldBeCalled();

        $this->view->render('footer/colophon', Argument::type('array'))->willReturn('footers/colophon');

        $this->defineFunction('do_blocks', static function (string $block) {
            Assert::assertEquals('footers/colophon', $block, '');
            return 'from do_block';
        });

        $event = new \ItalyStrap\Components\Footer\Events\Footer();
        $sut($event);
        $this->assertSame('from do_block', (string)$event);
    }
}
