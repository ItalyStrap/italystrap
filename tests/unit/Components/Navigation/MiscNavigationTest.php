<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Components\Navigation;

use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Navigation\UI\Components\MiscNavigation;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Header\Events\Content;
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
    public function itShouldListenToTheHeaderContentEventBeforeTheMainNavigation()
    {
        $sut = $this->getInstance();

        $this->assertSame(
            [
                Content::class => [
                    SubscriberInterface::CALLBACK => $sut,
                    SubscriberInterface::PRIORITY => 5,
                ],
            ],
            \iterator_to_array($sut->getSubscribedEvents()),
            ''
        );
    }

    /**
     * @test
     */
    public function itShouldAppendToTheEvent()
    {
        $sut = $this->getInstance();

        $this->view->render(MiscNavigation::TEMPLATE_NAME, Argument::type('array'))->willReturn('headers/navbar-top');

        $this->defineFunction('do_blocks', static function (string $block) {
            Assert::assertEquals('headers/navbar-top', $block, '');
            return 'from do_block';
        });

        $this->expectOutputString('');
        $this->tester->assertRenderableEventIsChanged($sut, 'from do_block');
    }
}
