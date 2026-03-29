<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\UI\Components\Posts\Parts;

use ItalyStrap\Tests\Unit\UI\Components\CommonRenderViewBlockTestTrait;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Posts\Parts\PostAuthorInfo;
use ItalyStrap\UI\Elements\AuthorInfo;
use PHPUnit\Framework\Assert;
use Prophecy\Argument;

class PostAuthorInfoTest extends UnitTestCase
{
    use CommonRenderViewBlockTestTrait;

    protected function makeInstance(): PostAuthorInfo
    {
        $sut = new PostAuthorInfo($this->makeConfig(), $this->makeAuthorInfo());
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    public function testItShouldLoad(): void
    {
        $sut = $this->makeInstance();

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

    public function testItShouldRenderWithViewBlockFromCommonTrait()
    {
        $this->author->__toString()->willReturn(AuthorInfo::TEMPLATE_NAME);
        $sut = $this->makeInstance();

        $this->view->render(AuthorInfo::TEMPLATE_NAME, Argument::type('array'))->willReturn(AuthorInfo::TEMPLATE_NAME);

        $this->tester->assertRenderableEventIsChanged($sut, AuthorInfo::TEMPLATE_NAME);
    }
}
