<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Components\Navigation;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Navigation\UI\Components\Pager;
use ItalyStrap\Tests\UnitTestCase;
use PHPUnit\Framework\Assert;
use Prophecy\Argument;

class PagerTest extends UnitTestCase
{
    protected function getInstance(): Pager
    {
        $sut = new Pager($this->getConfig(), $this->getView());
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    /**
     * @test
     */
    public function itShouldLoad()
    {
        $sut = $this->getInstance();

        $this->defineFunction('is_single', static fn() => true);

        $this->defineFunction('get_post_type', static fn() => 'post');

        $this->defineFunction(
            'post_type_supports',
            static function (string $post_type, string $feature) {
                Assert::assertEquals('post', $post_type, '');
                return true;
            }
        );

        $this->assertTrue($sut->shouldDisplay(), '');
    }

    /**
     * @test
     */
    public function itShouldDisplay()
    {
        $sut = $this->getInstance();
        $this->defineFunction('do_blocks', static fn(string $block) => 'block');

        $this->view->render(Pager::TEMPLATE_NAME, Argument::type('array'))->willReturn('block');
        $this->expectOutputString('block');
        $sut->display();
    }
}
