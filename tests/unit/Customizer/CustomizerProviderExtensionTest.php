<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Customizer;

use ItalyStrap\Customizer\CustomizerProviderExtension;
use ItalyStrap\Empress\Extension;
use ItalyStrap\Tests\UnitTestCase;
use Prophecy\Argument;

class CustomizerProviderExtensionTest extends UnitTestCase
{
    protected function getInstance(): CustomizerProviderExtension
    {
        $sut = new CustomizerProviderExtension($this->getDispatcher(), $this->getInjector());
        $this->assertInstanceOf(Extension::class, $sut, '');
        return $sut;
    }

    /**
     * @test
     */
    public function itShouldExecute()
    {
        $sut = $this->getInstance();

        $this->dispatcher
            ->addListener('customize_register', Argument::type('callable'), 99, 3)
            ->shouldBeCalledOnce();

        $sut->execute($this->getAurynConfigInterface());
    }

    /**
     * @test
     */
    public function itShouldWalk()
    {
        $sut = $this->getInstance();

        $class = 'ClassName';
        $index = 1;

        $object = new class {
            public function __invoke()
            {
                return 'Test';
            }
        };

        $this->injector->make($class)->willReturn($object);
        $this->injector
            ->execute(Argument::type('callable'))
            ->shouldBeCalledOnce()
            ->willReturn($object());

        $sut->walk($class, $index, $this->getInjector());
    }
}
