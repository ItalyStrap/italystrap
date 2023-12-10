<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Components\Navigation;

use ItalyStrap\Navigation\UI\Components\Pagination;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\ComponentInterface;

class PaginationTest extends UnitTestCase
{
    protected function getInstance(): Pagination
    {
        $sut = new Pagination($this->makeConfig(), $this->makeView());
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

        $this->view->render(Pagination::TEMPLATE_NAME)->willReturn('block');
        $this->expectOutputString('block');
        $sut->display();
    }
}