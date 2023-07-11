<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Config;

use ItalyStrap\Config\ConfigThemeProvider;
use ItalyStrap\Tests\BaseUnitTrait;
use Prophecy\Argument;

class ConfigThemeProviderTest extends \Codeception\Test\Unit
{
    use BaseUnitTrait;

    protected function getInstance(): ConfigThemeProvider
    {
        $sut = new ConfigThemeProvider($this->getTheme(), $this->getDispatcher());
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
