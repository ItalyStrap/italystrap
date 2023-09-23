<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Components;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Components\Entry;
use ItalyStrap\Tests\UnitTestCase;
use Prophecy\Argument;

class EntryTest extends UnitTestCase
{
    protected function getInstance(): Entry
    {
        $sut = new Entry($this->getConfig(), $this->getView(), $this->makeGlobalDispatcher());
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

        $this->defineFunction('get_post_class', static fn(): array => [
                'class-1'
            ]);

        $this->defineFunction('has_post_thumbnail', static fn(): bool => true);

        $this->defineFunction('get_the_ID', static fn(): int => 1);

        $this->view->render('posts/entry-post', Argument::type('array'))->willReturn('posts/entry-post');

        $this->expectOutputString('posts/entry-post');
        $sut->display();
    }
}
