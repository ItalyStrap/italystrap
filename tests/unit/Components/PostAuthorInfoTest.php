<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Components;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Components\PostAuthorInfo;
use ItalyStrap\Tests\UnitTestCase;
use PHPUnit\Framework\Assert;

class PostAuthorInfoTest extends UnitTestCase
{
    protected function getInstance(): PostAuthorInfo
    {
        $sut = new PostAuthorInfo($this->makeConfig(), $this->makeAuthorInfo());
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    /**
     * @test
     */
    public function itShouldLoad()
    {
        $sut = $this->getInstance();

        $this->defineFunction('get_post_type', static fn(): string => 'post');

        $this->defineFunction(
            'post_type_supports',
            static function (string $post_type, string $feature): bool {
                Assert::assertEquals('post', $post_type, '');
                return true;
            }
        );

        $this->defineFunction(
            'is_singular',
            static fn(): bool => true
        );

        $this->config->get('post_content_template')->willReturn([]);

        $this->assertTrue($sut->shouldDisplay(), '');
    }

    /**
     * @test
     */
    public function itShouldDisplay()
    {
        $sut = $this->getInstance();

        $this->author->render(null, [])->willReturn('some-string');

        $this->expectOutputString('some-string');
        $sut->display();
    }
}
