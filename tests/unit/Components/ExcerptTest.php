<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Components;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Components\Excerpt;
use ItalyStrap\Tests\UnitTestCase;
use PHPUnit\Framework\Assert;
use Prophecy\Argument;

class ExcerptTest extends UnitTestCase
{
    protected function getInstance(): Excerpt
    {
        $sut = new Excerpt($this->makeConfig(), $this->makeView());
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    /**
     * @test
     */
    public function itShouldLoad()
    {
        $sut = $this->getInstance();

        $this->defineFunction('is_singular', static fn() => false);

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

    /**
     * @test
     */
    public function itShouldDisplay()
    {
        $sut = $this->getInstance();
        $this->defineFunction('do_blocks', static fn(string $block) => 'block');

        $this->view->render('temp/excerpt', Argument::type('array'))->willReturn('block');
        $this->expectOutputString('block');
        $sut->display();
    }
}
