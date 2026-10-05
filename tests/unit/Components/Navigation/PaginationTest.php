<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Components\Navigation;

use ItalyStrap\Navigation\UI\Components\Pagination;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Posts\Events\PostsContentAfter;

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
        $this->view->render(Pagination::TEMPLATE_NAME)->willReturn('block');

        $event = new PostsContentAfter();
        $sut->display($event);

        $this->assertSame('block', (string)$event, 'The block markup is appended to the event, not echoed.');
    }
}
