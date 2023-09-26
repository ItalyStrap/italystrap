<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Components\Navigation;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Navigation\UI\Components\Pagination;
use ItalyStrap\Tests\UnitTestCase;
use Prophecy\Argument;

class PaginationTest extends UnitTestCase
{
    protected function getInstance(): Pagination
    {
        $sut = new Pagination($this->getConfig(), $this->getView());
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    /**
     * @test
     */
    public function itShouldLoad()
    {
        $sut = $this->getInstance();

        $this->defineFunction('is_404', static fn() => false);

        $this->assertTrue($sut->shouldDisplay(), '');
    }

    /**
     * @test
     */
    public function itShouldDisplay()
    {
        $sut = $this->getInstance();
        $this->defineFunction('do_blocks', static fn(string $block) => 'block');

        $this->view->render(Pagination::TEMPLATE_NAME, Argument::type('array'))->willReturn('block');
        $this->expectOutputString('block');
        $sut->display();
    }
}
