<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Components;

use ItalyStrap\Components\ArchiveAuthorInfo;
use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Test\Components\UndefinedFunctionDefinitionTrait;
use ItalyStrap\Tests\BaseUnitTrait;
use PHPUnit\Framework\Assert;

class ArchiveAuthorInfoTest extends \Codeception\Test\Unit
{
    use BaseUnitTrait;
    use UndefinedFunctionDefinitionTrait;

    protected function getInstance(): ArchiveAuthorInfo
    {
        $sut = new ArchiveAuthorInfo($this->getConfig(), $this->getAuthorInfo());
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    /**
     * @test
     */
    public function itShouldLoad()
    {
        $sut = $this->getInstance();

        $this->defineFunction('is_author', static fn(): bool => true);

        $this->assertTrue($sut->shouldDisplay(), '');
    }

    /**
     * @test
     */
    public function itShouldDisplay()
    {
        $sut = $this->getInstance();

        $this->author->render(null, [])->willReturn('some-string');

        $this->expectOutputString('some-string');
        $sut->display();
    }
}
