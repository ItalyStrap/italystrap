<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Components\Navigation;

use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Navigation\Domain\NavMenu;
use ItalyStrap\Navigation\Domain\NavMenuLocationInterface;
use ItalyStrap\Navigation\UI\Components\MainNavigationOlder;
use ItalyStrap\Navigation\UI\Components\NavMenuPrimary;
use ItalyStrap\Navigation\UI\Components\NavMenuSecondary;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Header\Events\Content;
use Prophecy\Argument;

class MainNavigationOlderTest extends UnitTestCase
{
    protected function makeInstance(): MainNavigationOlder
    {
        $menu = $this->prophet->prophesize(NavMenu::class)->reveal();
        $location = $this->prophet->prophesize(NavMenuLocationInterface::class)->reveal();

        $sut = new MainNavigationOlder(
            $this->makeConfig(),
            $this->makeView(),
            $this->makeNavbar(),
            new NavMenuPrimary($this->makeConfig(), $this->makeView(), $menu, $location),
            new NavMenuSecondary($this->makeConfig(), $this->makeView(), $menu, $location)
        );
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    public function testItShouldLoad(): void
    {
        $this->assertTrue($this->makeInstance()->shouldDisplay(), '');
    }

    public function testItShouldListenToTheHeaderContentEvent(): void
    {
        $sut = $this->makeInstance();

        $this->assertSame(
            [
                Content::class => [
                    SubscriberInterface::CALLBACK => $sut,
                    SubscriberInterface::PRIORITY => MainNavigationOlder::EVENT_PRIORITY,
                ],
            ],
            \iterator_to_array($sut->getSubscribedEvents()),
            ''
        );
    }

    public function testItShouldAppendTheNavbarToTheEvent(): void
    {
        $sut = $this->makeInstance();

        $this->view->render(MainNavigationOlder::TEMPLATE_NAME, Argument::type('array'))->willReturn('navbar');
        $this->defineFunction('do_blocks', static fn(string $block): string => 'parsed ' . $block);

        $this->expectOutputString('');
        $this->tester->assertRenderableEventIsChanged($sut, 'parsed navbar');
    }
}
