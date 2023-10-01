<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\UI\Components\Main;

use ItalyStrap\Tests\IntegrationTestCase;
use ItalyStrap\UI\Components\Main\Index;

class IndexTest extends IntegrationTestCase
{
    public function makeInstance()
    {
        return $this->injector->make(Index::class);
    }

    public function testIndex(): void
    {
        $sut = $this->makeInstance();

        $event = new \ItalyStrap\UI\Components\Main\Events\Index();
        $sut($event);
        $this->assertNotEmpty((string)$event, 'It should not be empty');
    }
}
