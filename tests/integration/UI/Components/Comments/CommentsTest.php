<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\UI\Components\Comments;

use ItalyStrap\Tests\IntegrationTestCase;
use ItalyStrap\UI\Components\Comments\Comments;
use ItalyStrap\UI\Components\Main\Events\Content;

class CommentsTest extends IntegrationTestCase
{
    public function makeInstance(): Comments
    {
        return $this->injector->make(Comments::class);
    }

    public function testItRendersParsedCommentsPattern(): void
    {
        $sut = $this->makeInstance();
        $event = new Content();

        $sut($event);

        $output = (string) $event;

        $this->assertStringContainsString('wp-block-comments', $output);
        $this->assertStringContainsString('wp-block-comments-title', $output);
        $this->assertStringNotContainsString('<!-- wp:pattern', $output);
    }
}
