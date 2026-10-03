<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Shared\UI\Components;

trait IsDisplayableTestTrait
{
    public function testItShouldDisplay()
    {
        $sut = $this->makeInstance();
        $this->assertTrue($sut->shouldDisplay(), 'It should display');
    }
}
