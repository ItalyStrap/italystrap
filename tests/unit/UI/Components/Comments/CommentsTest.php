<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\UI\Components\Comments;

use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\Comments\Comments;
use ItalyStrap\UI\Components\ComponentInterface;
use PHPUnit\Framework\Assert;

class CommentsTest extends UnitTestCase
{
    protected function makeInstance(): Comments
    {
        $sut = new Comments($this->makeConfig(), $this->makeViewBlock());
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    public function testItShouldLoad()
    {
        $sut = $this->makeInstance();

        $this->defineFunction('is_singular', static fn() => true);

        $this->defineFunction('get_post_type', static fn() => 'post');

        $this->defineFunction(
            'post_type_supports',
            static function (string $post_type, string $feature) {
                Assert::assertEquals('post', $post_type, '');
                return true;
            }
        );

        $this->config->get('post_content_template')->willReturn([]);

        $this->assertTrue($sut->shouldDisplay(), '');
    }
}
