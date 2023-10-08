<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\UI\Components\Posts\Parts;

use ItalyStrap\Tests\Shared\UI\Components\IsDisplayableTestTrait;
use ItalyStrap\Tests\Unit\UI\Components\CommonRenderViewBlockTestTrait;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Posts\Parts\Modified;

class ModifiedTest extends UnitTestCase
{
    use IsDisplayableTestTrait;
    use CommonRenderViewBlockTestTrait;

    protected function makeInstance(): Modified
    {
        $sut = new Modified($this->makeView());
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }
}
