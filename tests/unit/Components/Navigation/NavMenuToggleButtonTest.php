<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Components\Navigation;

use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Navigation\UI\Components\Events\NavMenuHeaderContent;
use ItalyStrap\Navigation\UI\Components\NavMenuToggleButton;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\ComponentInterface;

class NavMenuToggleButtonTest extends UnitTestCase
{
    protected function makeInstance(): NavMenuToggleButton
    {
        $sut = new NavMenuToggleButton($this->makeConfig(), $this->makeView(), $this->makeGlobalDispatcher());
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    public function testItShouldLoad(): void
    {
        $this->assertTrue($this->makeInstance()->shouldDisplay(), '');
    }

    public function testItShouldListenToTheNavMenuHeaderContentEventBeforeTheBrand(): void
    {
        $sut = $this->makeInstance();

        $this->assertSame(
            [
                NavMenuHeaderContent::class => [
                    SubscriberInterface::CALLBACK => $sut,
                    SubscriberInterface::PRIORITY => 5,
                ],
            ],
            \iterator_to_array($sut->getSubscribedEvents()),
            ''
        );
    }

    public function testItShouldAppendTheToggleButtonToTheEvent(): void
    {
        $sut = $this->makeInstance();
        $event = new NavMenuHeaderContent();

        $this->expectOutputString('');
        $sut($event);

        $this->assertStringContainsString('navbar-toggler', (string)$event, '');
        $this->assertStringContainsString('aria-label="Toggle navigation"', (string)$event, '');
    }
}
