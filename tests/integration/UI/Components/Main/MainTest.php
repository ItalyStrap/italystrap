<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\UI\Components\Main;

use ItalyStrap\Tests\IntegrationTestCase;
use ItalyStrap\UI\Components\Main\Main;

class MainTest extends IntegrationTestCase
{
    public function makeInstance()
    {
        return $this->injector->make(Main::class);
    }

    public function testMain(): void
    {
        $sut = $this->makeInstance();

        $event = new \ItalyStrap\UI\Components\Main\Events\Canvas();
        $sut($event);
        $this->assertNotEmpty((string)$event, 'It should not be empty');
    }
}
