<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Components\Navigation;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Navigation\UI\Components\MiscNavigation;
use ItalyStrap\Tests\UnitTestCase;
use PHPUnit\Framework\Assert;
use Prophecy\Argument;

class MiscNavigationTest extends UnitTestCase
{
    protected function getInstance(): MiscNavigation
    {
        $sut = new MiscNavigation($this->makeConfig(), $this->makeView(), $this->makeGlobalDispatcher());
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    /**
     * @test
     */
    public function itShouldLoad()
    {

        $this->defineFunction('has_nav_menu', static fn() => true);

        $sut = $this->getInstance();
        $this->assertTrue($sut->shouldDisplay(), '');
    }

    /**
     * @test
     */
    public function itShouldDisplay()
    {
        $sut = $this->getInstance();

        $this->view->render(MiscNavigation::TEMPLATE_NAME, Argument::type('array'))->willReturn('headers/navbar-top');

        $this->defineFunction('do_blocks', static function (string $block) {
            Assert::assertEquals('headers/navbar-top', $block, '');
            return 'from do_block';
        });

        $this->expectOutputString('from do_block');
        $sut->display();
    }
}
