<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Navigation\UI\Components;

use ItalyStrap\Navigation\UI\Components\Events\NavMenuBefore;
use ItalyStrap\Navigation\UI\Components\NavMenuHeader;
use ItalyStrap\Tests\IntegrationTestCase;

class NavMenuHeaderTest extends IntegrationTestCase
{
    public function makeInstance(): NavMenuHeader
    {
        return $this->injector->make(NavMenuHeader::class);
    }

    public function testItRendersNavbarHeaderAndToggle(): void
    {
        $sut = $this->makeInstance();
        $event = new NavMenuBefore();

        \ob_start();
        $sut($event);
        $echoed = (string) \ob_get_clean();

        $this->assertSame('', $echoed, 'The header is appended to the event, not echoed.');

        $output = (string) $event;
        $this->assertStringContainsString('navbar-header', $output);
        $this->assertStringContainsString('navbar-toggler', $output);
        $this->assertStringContainsString('Toggle navigation', $output);
    }
}
