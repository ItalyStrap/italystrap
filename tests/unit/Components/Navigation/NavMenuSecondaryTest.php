<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Components\Navigation;

use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Navigation\Domain\NavMenu;
use ItalyStrap\Navigation\Domain\NavMenuLocationInterface;
use ItalyStrap\Navigation\UI\Components\Events\NavMenuContent;
use ItalyStrap\Navigation\UI\Components\NavMenuSecondary;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\ComponentInterface;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;

class NavMenuSecondaryTest extends UnitTestCase
{
    private ObjectProphecy $menu;

    protected function makeInstance(): NavMenuSecondary
    {
        $this->menu = $this->prophet->prophesize(NavMenu::class);
        $location = $this->prophet->prophesize(NavMenuLocationInterface::class);
        $location->has(NavMenuSecondary::class)->willReturn(true);

        $sut = new NavMenuSecondary($this->makeConfig(), $this->makeView(), $this->menu->reveal(), $location->reveal());
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    public function testItShouldLoad(): void
    {
        $this->assertTrue($this->makeInstance()->shouldDisplay(), '');
    }

    public function testItShouldListenToTheNavMenuContentEvent(): void
    {
        $sut = $this->makeInstance();

        $this->assertSame(
            [
                NavMenuContent::class => [
                    SubscriberInterface::CALLBACK => $sut,
                    SubscriberInterface::PRIORITY => NavMenuSecondary::EVENT_PRIORITY,
                ],
            ],
            \iterator_to_array($sut->getSubscribedEvents()),
            ''
        );
    }

    public function testItShouldRenderTheMenuForItsLocation(): void
    {
        $sut = $this->makeInstance();

        $this->menu
            ->render(Argument::that(static fn(array $options): bool =>
                $options[NavMenu::THEME_LOCATION] === NavMenuSecondary::class
                && $options[NavMenu::MENU_ID] === 'secondary-menu'))
            ->willReturn('menu');

        $this->expectOutputString('');
        $this->assertSame('menu', $sut->render(), '');
    }

    public function testItShouldAppendTheMenuToTheEvent(): void
    {
        $sut = $this->makeInstance();

        $this->menu->render(Argument::type('array'))->willReturn('menu');

        $this->expectOutputString('');
        $this->tester->assertRenderableEventIsChanged($sut, 'menu');
    }
}
