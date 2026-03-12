<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Navigation\UI\Components;

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

        \ob_start();
        $sut->display();
        $output = (string) \ob_get_clean();

        $this->assertStringContainsString('navbar-header', $output);
        $this->assertStringContainsString('navbar-toggler', $output);
        $this->assertStringContainsString('Toggle navigation', $output);
    }
}
