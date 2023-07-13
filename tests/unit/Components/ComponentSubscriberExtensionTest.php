<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Components;

use ItalyStrap\Components\ComponentSubscriberExtension;
use ItalyStrap\Components\Index;
use ItalyStrap\Empress\Extension;
use ItalyStrap\Tests\UnitTestCase;
use Prophecy\Argument;

class ComponentSubscriberExtensionTest extends UnitTestCase
{
    protected function getInstance(): ComponentSubscriberExtension
    {
        $sut = new ComponentSubscriberExtension($this->getSubscriberRegister(), $this->getDispatcher());
        $this->assertInstanceOf(Extension::class, $sut, '');
        return $sut;
    }

    /**
     * @test
     */
    public function itShouldHaveName()
    {
        $sut = $this->getInstance();
        $this->assertSame(ComponentSubscriberExtension::class, $sut->name());
    }

    /**
     * @test
     */
    public function itShouldExecute()
    {
        $sut = $this->getInstance();

        $this->dispatcher->addListener(
            Argument::type('string'),
            Argument::type('callable'),
            Argument::type('int'),
            Argument::type('int')
        )->shouldBeCalledOnce();

        $sut->execute($this->getAurynConfigInterface());
    }

    /**
     * @test
     */
    public function itShouldWalk()
    {
        $sut = $this->getInstance();
        $className = 'ClassName';
        $index_or_optionName = 0;

        $class = $this->prophet->prophesize(Index::class);

        $this->injector->share($className)->willReturn($this->injector);
        $this->injector->proxy($className, Argument::type('callable'))->willReturn($this->injector);
        $this->injector->make($className)->willReturn($class);

        $class->shouldDisplay()->willReturn(true);

        $this->subscriberRegister->addSubscriber($class)->shouldBeCalledOnce();

        $sut->walk($className, $index_or_optionName, $this->getInjector());
    }
}
