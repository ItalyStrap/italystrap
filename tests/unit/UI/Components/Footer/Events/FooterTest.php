<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Components\Main\Events;

use ItalyStrap\Tests\Shared\UI\Components\RenderableEventTestTrait;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\Footer\Events\Content;

class FooterTest extends UnitTestCase
{
    use RenderableEventTestTrait;

    private function makeInstance(): Content
    {
        return new Content();
    }
}
