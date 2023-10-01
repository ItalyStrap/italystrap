<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\UI\Components\Posts\NotFound;

use ItalyStrap\Tests\Shared\UI\Components\IsDisplayableTestTrait;
use ItalyStrap\Tests\Unit\UI\Components\CommonRenderViewBlockTestTrait;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Posts\NotFound\Content;
use ItalyStrap\UI\Elements\Search;

class ContentTest extends UnitTestCase
{
    use IsDisplayableTestTrait;
    use CommonRenderViewBlockTestTrait;

    protected function makeInstance(): Content
    {
        $sut = new Content(
            $this->makeConfig(),
            $this->makeViewBlock(),
            new Search(
                $this->makeView(),
                $this->makeTag(),
            )
        );
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    public function testItShouldRenderWithViewBlockFromCommonTrait()
    {
        $this->markTestSkipped('Implement this test');
    }
}
