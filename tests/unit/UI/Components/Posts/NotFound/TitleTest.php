<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\UI\Components\Posts\NotFound;

use ItalyStrap\Tests\Shared\UI\Components\IsDisplayableTestTrait;
use ItalyStrap\Tests\Unit\UI\Components\CommonRenderViewBlockTestTrait;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Posts\NotFound\Title;

class TitleTest extends UnitTestCase
{
    use IsDisplayableTestTrait;
    use CommonRenderViewBlockTestTrait;

    protected function makeInstance(): Title
    {
        $sut = new Title($this->makeConfig(), $this->makeViewBlock());
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }
}
