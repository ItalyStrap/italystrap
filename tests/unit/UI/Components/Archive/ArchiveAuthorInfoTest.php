<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\UI\Components\Archive;

use ItalyStrap\Tests\Unit\UI\Components\CommonRenderViewBlockTestTrait;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\Archive\ArchiveAuthorInfo;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Elements\AuthorInfo;

class ArchiveAuthorInfoTest extends UnitTestCase
{
    use CommonRenderViewBlockTestTrait;

    protected function makeInstance(): ArchiveAuthorInfo
    {
        $sut = new ArchiveAuthorInfo($this->makeAuthorInfo());
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    public function testItShouldLoad()
    {
        $sut = $this->makeInstance();

        $this->defineFunction('is_author', static fn(): bool => true);

        $this->assertTrue($sut->shouldDisplay(), '');
    }

    public function testItShouldRenderWithViewBlockFromCommonTrait()
    {
        $this->author->__toString()->willReturn(AuthorInfo::TEMPLATE_NAME);
        $sut = $this->makeInstance();

        $this->tester->assertRenderableEventIsChanged($sut, AuthorInfo::TEMPLATE_NAME);
    }
}
