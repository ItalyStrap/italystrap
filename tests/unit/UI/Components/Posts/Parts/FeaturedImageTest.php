<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\UI\Components\Posts\Parts;

use ItalyStrap\Tests\Unit\UI\Components\CommonRenderViewBlockTestTrait;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\Theme\Infrastructure\Config\ConfigPostThumbnailProvider;
use ItalyStrap\Theme\Infrastructure\Json;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Posts\Parts\FeaturedImage;
use PHPUnit\Framework\Assert;

class FeaturedImageTest extends UnitTestCase
{
    use CommonRenderViewBlockTestTrait {
        testItShouldRenderWithViewBlockFromCommonTrait as ItShouldRenderFromCommonTrait;
    }

    protected function makeInstance(): FeaturedImage
    {
        $sut = new FeaturedImage(
            $this->makeConfig(),
            $this->makeView(),
            new Json()
        );
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    public function testItShouldLoad()
    {
        $sut = $this->makeInstance();

        $this->defineFunction('get_post_type', static fn() => 'post');

        $this->defineFunction(
            'post_type_supports',
            static function (string $post_type, string $feature) {
                Assert::assertEquals('post', $post_type, '');
                return true;
            }
        );

        $this->config->get('post_content_template', [])->willReturn([]);

        $this->assertTrue($sut->shouldDisplay(), '');
    }

    public function testItShouldRender()
    {
        $size_slig_result = 'full_width';
        $this->config->get(ConfigPostThumbnailProvider::POST_THUMBNAIL_SIZE)->willReturn($size_slig_result);
        $this->config->get('site_layout')->willReturn($size_slig_result);
        $this->config->get(ConfigPostThumbnailProvider::POST_THUMBNAIL_ALIGNMENT)->willReturn($size_slig_result);

        $this->defineFunction('is_page_template', static function (string $template) {
            Assert::assertSame('full-width.php', $template, '');
            return 'full-width';
        });

        $this->ItShouldRenderFromCommonTrait();
    }
}
