<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Config;

use ItalyStrap\Config\ConfigThemeModsProvider;
use ItalyStrap\Tests\UnitTestCase;

class ConfigThemeModsProviderTest extends UnitTestCase
{
    protected function getInstance(): ConfigThemeModsProvider
    {
        $sut = new ConfigThemeModsProvider([]);
        $this->assertInstanceOf(ConfigThemeModsProvider::class, $sut, '');
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
