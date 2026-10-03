<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\UI\Components\Main;

use ItalyStrap\Tests\Shared\UI\Components\IsDisplayableTestTrait;
use ItalyStrap\Tests\Unit\UI\Components\CommonRenderViewBlockTestTrait;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Main\Main;

class CanvasTest extends UnitTestCase
{
    use IsDisplayableTestTrait;
    use CommonRenderViewBlockTestTrait;

    protected function makeInstance(): Main
    {
        $sut = new Main(
            $this->makeConfig(),
            $this->makeView(),
            $this->makeDispatcher()
        );
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }
}
