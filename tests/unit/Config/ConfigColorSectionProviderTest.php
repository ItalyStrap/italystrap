<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Config;

use ItalyStrap\Config\ConfigColorSectionProvider;
use ItalyStrap\Tests\UnitTestCase;

class ConfigColorSectionProviderTest extends UnitTestCase
{
    protected function getInstance(): ConfigColorSectionProvider
    {
        $sut = new ConfigColorSectionProvider([]);
        $this->assertInstanceOf(ConfigColorSectionProvider::class, $sut, '');
        return $sut;
    }

    /**
     * @test
     */
    public function itShouldExecute()
    {
        $sut = $this->getInstance();
        $sut();
    }
}
