<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\UI\Components\Posts\Parts;

use ItalyStrap\Tests\Unit\UI\Components\CommonRenderViewBlockTestTrait;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\Theme\Infrastructure\Json;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Posts\Parts\Title;
use PHPUnit\Framework\Assert;

class TitleTest extends UnitTestCase
{
    use CommonRenderViewBlockTestTrait {
        testItShouldRenderWithViewBlockFromCommonTrait as ItShouldRenderFromCommonTrait;
    }

    protected function makeInstance(): Title
    {
        $sut = new Title(
            $this->makeConfig(),
            $this->makeView(),
            new Json()
        );
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    public function testItShouldDisplay()
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

    public function testItShouldRenderWithViewBlockFromCommonTrait()
    {
        $this->defineFunction('is_singular', static fn(): bool => true);

        $this->ItShouldRenderFromCommonTrait();
    }
}
