<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Config;

use ItalyStrap\Config\ConfigProviderExtension;
use ItalyStrap\Empress\Extension;
use ItalyStrap\Tests\UnitTestCase;
use Prophecy\Argument;

class ConfigProviderExtensionTest extends UnitTestCase
{
    protected function getInstance(): ConfigProviderExtension
    {
        $sut = new ConfigProviderExtension($this->getConfig());
        $this->assertInstanceOf(Extension::class, $sut, '');
        return $sut;
    }

    /**
     * @test
     */
    public function itShouldExecute()
    {
        $sut = $this->getInstance();

        $this->aurynConfigInterface
            ->walk(Argument::type('string'), Argument::type('callable'))
            ->shouldBeCalledOnce();

        $sut->execute($this->getAurynConfigInterface());
    }

    /**
     * @test
     */
    public function itShouldWalkForCallable()
    {
        $sut = $this->getInstance();
        $className = 'ClassName';
        $index_or_optionName = 0;

        $class = new class {
            public function __invoke(): iterable
            {
                return [
                    'key' => 'value',
                ];
            }
        };

        $this->injector->share($className)->willReturn($this->injector);
        $this->injector->make($className)->willReturn($class);
        $this->injector
            ->execute(Argument::type('callable'))
            ->shouldBeCalledOnce()
            ->willReturn($class());

        $this->config->merge(Argument::exact($class()))->shouldBeCalledOnce();

        $sut($className, $index_or_optionName, $this->getInjector());
    }
}
