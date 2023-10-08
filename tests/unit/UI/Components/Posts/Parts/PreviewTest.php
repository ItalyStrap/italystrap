<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\UI\Components\Posts\Parts;

use ItalyStrap\Tests\Unit\UI\Components\CommonRenderViewBlockTestTrait;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Posts\Parts\Preview;

class PreviewTest extends UnitTestCase
{
    use CommonRenderViewBlockTestTrait;

    protected function makeInstance(): Preview
    {
        $sut = new Preview(
            $this->makeView()
        );
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    public function testItShouldLoad()
    {
        $sut = $this->makeInstance();

        $this->defineFunction('is_preview', static fn(): bool => true);

        $this->assertTrue($sut->shouldDisplay(), '');
    }
}
