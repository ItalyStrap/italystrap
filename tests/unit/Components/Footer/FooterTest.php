<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Components\Footer;

use ItalyStrap\Components\Footer\Footer;
use ItalyStrap\Tests\UnitTestCase;
use Prophecy\Argument;

class FooterTest extends UnitTestCase
{
    protected function makeInstance(): Footer
    {
        return new Footer(
            $this->getConfig(),
            $this->getView(),
            $this->makeGlobalDispatcher(),
            $this->makeDispatcher(),
        );
    }

    /**
     * @test
     */
    public function itShouldLoad()
    {
        $sut = $this->makeInstance();
        $this->assertTrue($sut->shouldDisplay(), '');
    }

    /**
     * @test
     */
    public function itShouldDisplay()
    {
        $sut = $this->makeInstance();
        $expected_output = 'footer/footer';

        $this->view->render('footer/footer', Argument::type('array'))->willReturn($expected_output);

        $this->expectOutputString($expected_output);
        $sut->display();
    }
}
