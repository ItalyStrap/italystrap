<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Components\Footer;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Components\Footer\FooterWidgetArea;
use ItalyStrap\Tests\UnitTestCase;
use PHPUnit\Framework\Assert;
use Prophecy\Argument;

class FooterWidgetAreaTest extends UnitTestCase
{
    protected function getInstance(): FooterWidgetArea
    {
        $sut = new FooterWidgetArea($this->getConfig(), $this->getView());
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

        $this->config->toArray()->willReturn([]);

        $this->view->render('footer/widget-area', Argument::type('array'))->willReturn('footers/widget-area');

        $this->defineFunction('do_blocks', static function (string $block) {
            Assert::assertEquals('footers/widget-area', $block, '');
            return 'from do_block';
        });

        $this->expectOutputString('from do_block');
        $sut->display();
    }
}
