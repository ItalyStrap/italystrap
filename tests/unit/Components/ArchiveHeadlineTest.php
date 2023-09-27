<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Components;

use ItalyStrap\Components\ArchiveHeadline;
use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Tests\UnitTestCase;
use PHPUnit\Framework\Assert;
use Prophecy\Argument;

class ArchiveHeadlineTest extends UnitTestCase
{
    protected function getInstance(): ArchiveHeadline
    {
        $sut = new ArchiveHeadline($this->makeConfig(), $this->makeView(), $this->makeGlobalDispatcher());
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    /**
     * @test
     */
    public function itShouldLoad()
    {

        $this->defineFunction('is_archive', static fn() => true);

        $this->defineFunction('is_search', static fn() => true);

        $this->defineFunction('is_author', static fn() => false);

        $sut = $this->getInstance();
        $this->assertTrue($sut->shouldDisplay(), '');
    }

    /**
     * @test
     */
    public function itShouldDisplay()
    {
        $sut = $this->getInstance();

        $this->view->render('misc/archive-headline', Argument::type('array'))->willReturn('misc/archive-headline');

        $this->defineFunction('do_blocks', static function (string $block) {
            Assert::assertEquals('misc/archive-headline', $block, '');
            return 'from do_block';
        });

        $this->expectOutputString('from do_block');
        $sut->display();
    }
}
