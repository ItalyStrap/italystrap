<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Components\Main\Events;

use ItalyStrap\Components\Main\Events\Index;
use ItalyStrap\Tests\UnitTestCase;

class IndexTest extends UnitTestCase
{
    private function makeInstance(): Index
    {
        return new Index('templateName');
    }

    public function testItShouldBeInstantiable()
    {
        $this->assertInstanceOf(Index::class, $this->makeInstance(), '');
    }
}