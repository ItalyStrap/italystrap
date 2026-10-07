<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Components\Navigation;

use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Navigation\UI\Components\MainNavigation;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Header\Events\Content;
use PHPUnit\Framework\Assert;
use Prophecy\Argument;

class MainNavigationTest extends UnitTestCase
{
    protected function getInstance(): MainNavigation
    {
        $sut = new MainNavigation($this->makeConfig(), $this->makeView(), $this->makeDispatcher());
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
    public function itShouldListenToTheHeaderContentEvent()
    {
        $sut = $this->getInstance();

        $this->assertSame(
            [
                Content::class => [
                    SubscriberInterface::CALLBACK => $sut,
                    SubscriberInterface::PRIORITY => MainNavigation::EVENT_PRIORITY,
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

        $this->view->render(MainNavigation::TEMPLATE_NAME, Argument::type('array'))->willReturn('headers/navbar');

        $this->defineFunction('do_blocks', static function (string $block) {
            Assert::assertEquals('headers/navbar', $block, '');
            return 'from do_block';
        });

        $this->expectOutputString('');
        $this->tester->assertRenderableEventIsChanged($sut, 'from do_block');
    }
}
