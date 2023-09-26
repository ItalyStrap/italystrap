<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Components\Main\Events;

use ItalyStrap\Components\Footer\Events\Footer;
use ItalyStrap\Tests\RenderableEventTestTrait;
use ItalyStrap\Tests\UnitTestCase;

class FooterTest extends UnitTestCase
{
    use RenderableEventTestTrait;

    private function makeInstance(): Footer
    {
        return new Footer();
    }
}
