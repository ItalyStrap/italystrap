<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Components;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Components\Index;
use ItalyStrap\Tests\UnitTestCase;
use PHPUnit\Framework\Assert;
use Prophecy\Argument;

class IndexTest extends UnitTestCase
{
    protected function getInstance(): Index
    {
        $sut = new Index($this->getConfig(), $this->getView(), $this->getDispatcher());
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

        $this->view->render('index', Argument::type('array'))->willReturn('index');

        $this->defineFunction('do_blocks', static function (string $block) {
            Assert::assertEquals('index', $block, '');
            return 'from do_block';
        });

        $this->expectOutputString('from do_block');
        $sut->display();
    }
}
