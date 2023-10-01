<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\UI\Components\Main;

use ItalyStrap\Tests\Shared\UI\Components\IsDisplayableTestTrait;
use ItalyStrap\Tests\Unit\UI\Components\CommonRenderViewBlockTestTrait;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Main\Index;

class IndexTest extends UnitTestCase
{
    use IsDisplayableTestTrait;
    use CommonRenderViewBlockTestTrait;

    protected function makeInstance(): Index
    {
        $sut = new Index(
            $this->makeConfig(),
            $this->makeViewBlock(),
            $this->makeDispatcher()
        );
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }
}
