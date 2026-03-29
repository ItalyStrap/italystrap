<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Integration;

use Auryn\Injector;
use ItalyStrap\Tests\IntegrationTestCase;

use function ItalyStrap\Factory\injector;

class AppTest extends IntegrationTestCase
{
    public function testItShouldBeInjectorInstance()
    {
        $sut = injector();
        $this->assertInstanceOf(Injector::class, $sut, '');
    }
}
