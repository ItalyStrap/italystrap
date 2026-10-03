<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\UI\Components;

use ItalyStrap\Tests\IntegrationTestCase;
use ItalyStrap\UI\Components\Posts\Events\PostContent;
use ItalyStrap\UI\Components\Posts\Parts\Title;

class TitleTest extends IntegrationTestCase
{
    public function makeInstance(): Title
    {
        return $this->injector->make(Title::class);
    }

    public function testItShouldDisplay()
    {
        $sut = $this->makeInstance();
        $GLOBALS['post'] = $this->factory()->post->create_and_get();

        $this->assertTrue($sut->shouldDisplay(), '');
    }

    public function testItShouldRender()
    {
        $sut = $this->makeInstance();
        $GLOBALS['post'] = $this->factory()->post->create_and_get();

        $event = new PostContent();
        $sut($event);

        $this->assertStringContainsString('wp-block-group page-header entry-header', (string)$event);
        $this->assertStringContainsString('entry-title', (string)$event);
    }
}
