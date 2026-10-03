<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\UI\Components\Main\Events;

use ItalyStrap\Tests\Shared\UI\Components\RenderableEventTestTrait;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\Main\Events\Index;

class IndexTest extends UnitTestCase
{
    use RenderableEventTestTrait;

    private function makeInstance(): Index
    {
        return new Index('templateName');
    }

    public function testItShouldBeInstantiable()
    {
        $this->assertInstanceOf(Index::class, $this->makeInstance(), '');
    }
}
