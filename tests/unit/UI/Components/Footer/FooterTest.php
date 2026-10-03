<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\UI\Components\Footer;

use ItalyStrap\Tests\Shared\UI\Components\IsDisplayableTestTrait;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\Footer\Footer;
use Prophecy\Argument;

class FooterTest extends UnitTestCase
{
    use IsDisplayableTestTrait;

    protected function makeInstance(): Footer
    {
        return new Footer(
            $this->makeView(),
            $this->makeTag(),
            $this->makeDispatcher(),
        );
    }

    public function testItShouldRender()
    {
        $sut = $this->makeInstance();

        $this->view->render($sut::TEMPLATE_NAME, Argument::type('array'))->willReturn($sut::TEMPLATE_NAME);

        $this->tester->assertRenderableEventIsChanged($sut, $sut::TEMPLATE_NAME);
    }
}
