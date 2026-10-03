<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\UI\Components\Footer;

use ItalyStrap\Tests\IntegrationTestCase;
use ItalyStrap\UI\Components\Footer\Events\Content;
use ItalyStrap\UI\Components\Footer\FooterWidgetArea;

class FooterWidgetAreaTest extends IntegrationTestCase
{
    public function makeInstance(): FooterWidgetArea
    {
        return $this->injector->make(FooterWidgetArea::class);
    }

    public function testItRendersWidgetAreaMarkup(): void
    {
        $sut = $this->makeInstance();
        $event = new Content();

        $sut($event);

        $output = (string) $event;

        $this->assertStringContainsString('wp-block-columns', $output);
        $this->assertStringContainsString('wp-block-group alignfull', $output);
        $this->assertStringNotContainsString('footer_sidebars', $output);
    }
}
