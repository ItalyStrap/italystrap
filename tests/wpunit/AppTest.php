<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\WPUnit;

use Auryn\Injector;
use ItalyStrap\Tests\WPTestCase;

use function ItalyStrap\Factory\injector;

class AppTest extends WPTestCase
{
    /**
     * @test
     */
    public function itShouldBeInstantiable()
    {
        $sut = injector();
        $this->assertInstanceOf(Injector::class, $sut, '');
    }
}
