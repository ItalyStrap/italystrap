<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Components\Navigation;

use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Navigation\UI\Components\Events\NavMenuBefore;
use ItalyStrap\Navigation\UI\Components\NavMenuHeader;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\ComponentInterface;
use Prophecy\Argument;

class NavMenuHeaderTest extends UnitTestCase
{
    protected function makeInstance(): NavMenuHeader
    {
        $sut = new NavMenuHeader($this->makeConfig(), $this->makeView(), $this->makeDispatcher());
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    public function testItShouldLoad(): void
    {
        $this->assertTrue($this->makeInstance()->shouldDisplay(), '');
    }

    public function testItShouldListenToTheNavMenuBeforeEvent(): void
    {
        $sut = $this->makeInstance();

        $this->assertSame(
            [
                NavMenuBefore::class => [
                    SubscriberInterface::CALLBACK => $sut,
                    SubscriberInterface::PRIORITY => NavMenuHeader::EVENT_PRIORITY,
                ],
            ],
            \iterator_to_array($sut->getSubscribedEvents()),
            ''
        );
    }

    public function testItShouldAppendTheHeaderViewToTheEvent(): void
    {
        $sut = $this->makeInstance();

        $this->view->render(NavMenuHeader::TEMPLATE_NAME, Argument::type('array'))->willReturn('navbar-header');

        $this->expectOutputString('');
        $this->tester->assertRenderableEventIsChanged($sut, 'navbar-header');
    }
}
