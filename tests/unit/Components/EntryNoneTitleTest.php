<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Components;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Components\EntryNoneTitle;
use ItalyStrap\Config\ConfigNotFoundProvider;
use ItalyStrap\Tests\UnitTestCase;
use PHPUnit\Framework\Assert;
use Prophecy\Argument;

class EntryNoneTitleTest extends UnitTestCase
{
    protected function getInstance(): EntryNoneTitle
    {
        $sut = new EntryNoneTitle($this->getConfig(), $this->getView(), $this->getDispatcher());
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

        $this->config->get(ConfigNotFoundProvider::TITLE)->willReturn('Some content');

        $this->view->render('posts/none/title', Argument::type('array'))->willReturn('posts/none/title');

        $this->defineFunction('do_blocks', static function (string $block) {
            Assert::assertEquals('posts/none/title', $block, '');
            return 'from do_block';
        });

        $this->expectOutputString('from do_block');
        $sut->display();
    }
}
