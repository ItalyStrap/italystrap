<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Components;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Components\Header;
use ItalyStrap\Test\Components\UndefinedFunctionDefinitionTrait;
use ItalyStrap\Tests\BaseUnitTrait;
use PHPUnit\Framework\Assert;
use Prophecy\Argument;

class HeaderTest extends \Codeception\Test\Unit
{
    use BaseUnitTrait;
    use UndefinedFunctionDefinitionTrait;

    protected function getInstance(): Header
    {
        $sut = new Header($this->getConfig(), $this->getView(), $this->getDispatcher(), $this->getTag());
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }

    /**
     * @test
     */
    public function itShouldLoad()
    {
        $sut = $this->getInstance();
        $this->assertTrue($sut->shouldDisplay(), '');
    }

    /**
     * @test
     */
    public function itShouldDisplay()
    {
        $sut = $this->getInstance();

        $this->config->get('current_template_slug')->willReturn('');

        $this->defineFunction('get_body_class', static fn(): array => [
                'class-1',
                'class-2',
            ]);

        $this->view->render('header', Argument::type('array'))->willReturn('header');

        $this->expectOutputString('header');
        $sut->display();
    }
}
