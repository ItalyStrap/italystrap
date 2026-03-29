<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\UI\Components\Archive;

use ItalyStrap\Tests\Unit\UI\Components\CommonRenderViewBlockTestTrait;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\Archive\SearchHeadline;
use ItalyStrap\UI\Components\ComponentInterface;

class SearchHeadlineTest extends UnitTestCase
{
    use CommonRenderViewBlockTestTrait;

    protected function makeInstance(): SearchHeadline
    {
        $sut = new SearchHeadline($this->makeViewBlock());
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    public function testItShouldDisplay()
    {
        $this->defineFunction('is_search', static fn() => true);

        $sut = $this->makeInstance();
        $this->assertTrue($sut->shouldDisplay(), '');
    }
}
