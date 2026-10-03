<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\UI\Components\Posts;

use ItalyStrap\Tests\Shared\UI\Components\IsDisplayableTestTrait;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Posts\Post;
use Prophecy\Argument;

class PostTest extends UnitTestCase
{
    use IsDisplayableTestTrait;

    protected function makeInstance(): Post
    {
        $sut = new Post($this->makeConfig(), $this->makeView(), $this->makeDispatcher());
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    public function testItShouldRender()
    {
        $sut = $this->makeInstance();

        $this->defineFunction('get_post_class', static fn(): array => [
                'class-1'
            ]);

        $this->defineFunction('has_post_thumbnail', static fn(): bool => true);

        $this->defineFunction('get_the_ID', static fn(): int => 1);

        $this->view->render(Post::TEMPLATE_NAME, Argument::type('array'))->willReturn(Post::TEMPLATE_NAME);

        $this->tester->assertRenderableEventIsChanged($sut, Post::TEMPLATE_NAME);
    }
}
