<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Config;

use ItalyStrap\Config\ConfigColorSectionProvider;
use ItalyStrap\Tests\BaseUnitTrait;
use Prophecy\Argument;

class ConfigColorSectionProviderTest extends \Codeception\Test\Unit
{
    use BaseUnitTrait;

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
