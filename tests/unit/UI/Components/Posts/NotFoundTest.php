<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\UI\Components\Posts;

use ItalyStrap\Tests\Shared\UI\Components\IsDisplayableTestTrait;
use ItalyStrap\Tests\Unit\UI\Components\CommonRenderViewBlockTestTrait;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Posts\NotFound;

class NotFoundTest extends UnitTestCase
{
    use IsDisplayableTestTrait;
    use CommonRenderViewBlockTestTrait;

    protected function makeInstance(): NotFound
    {
        $sut = new NotFound($this->makeViewBlock(), $this->makeDispatcher());
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }
}
