<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Components\Navigation;

use ItalyStrap\Navigation\UI\Components\MainNavigation;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\ComponentInterface;
use PHPUnit\Framework\Assert;
use Prophecy\Argument;

class MainNavigationTest extends UnitTestCase
{
    protected function getInstance(): MainNavigation
    {
        $sut = new MainNavigation($this->makeConfig(), $this->makeView(), $this->makeGlobalDispatcher());
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

        $this->view->render(MainNavigation::TEMPLATE_NAME, Argument::type('array'))->willReturn('headers/navbar');

        $this->defineFunction('do_blocks', static function (string $block) {
            Assert::assertEquals('headers/navbar', $block, '');
            return 'from do_block';
        });

        $this->expectOutputString('from do_block');
        $sut->display();
    }
}
