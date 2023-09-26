<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Components\Main;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Components\Main\Index;
use ItalyStrap\Tests\UnitTestCase;
use PHPUnit\Framework\Assert;
use Prophecy\Argument;

class IndexTest extends UnitTestCase
{
    protected function makeInstance(): Index
    {
        $sut = new Index($this->getConfig(), $this->getView(), $this->makeGlobalDispatcher());
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    public function testItShouldLoad()
    {
        $sut = $this->makeInstance();
        $this->assertTrue($sut->shouldDisplay(), '');
    }

    public function testItShouldRender()
    {
        $sut = $this->makeInstance();

        $this->view->render(Index::TEMPLATE_NAME, Argument::type('array'))->willReturn('index');

        $this->defineFunction('do_blocks', static function (string $block) {
            Assert::assertEquals('index', $block, '');
            return 'from do_block';
        });

        $event = new \ItalyStrap\Components\Main\Events\Index();
        $sut($event);
        $this->assertSame('from do_block', (string)$event);
    }
}
