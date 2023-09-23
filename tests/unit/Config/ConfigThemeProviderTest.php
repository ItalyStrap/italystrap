<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Config;

use ItalyStrap\Config\ConfigThemeProvider;
use ItalyStrap\Tests\UnitTestCase;

class ConfigThemeProviderTest extends UnitTestCase
{
    protected function getInstance(): ConfigThemeProvider
    {
        $sut = new ConfigThemeProvider($this->getTheme(), $this->makeGlobalDispatcher());
        $this->assertInstanceOf(ConfigThemeProvider::class, $sut, '');
        return $sut;
    }

    /**
     * @test
     */
    public function itShouldExecute()
    {
        $sut = $this->getInstance();
//      $this->theme->display(Argument::type('string'))->shouldBeCalled();
        $sut();
    }
}
