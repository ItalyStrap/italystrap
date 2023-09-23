<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Components;

use ItalyStrap\Components\ComponentSubscriberExtension;
use ItalyStrap\Components\Main\Index;
use ItalyStrap\Empress\Extension;
use ItalyStrap\Tests\UnitTestCase;
use Prophecy\Argument;

class ComponentSubscriberExtensionTest extends UnitTestCase
{
    protected function makeInstance(): ComponentSubscriberExtension
    {
        $sut = new ComponentSubscriberExtension($this->getSubscriberRegister(), $this->getListenerRegister());
        $this->assertInstanceOf(Extension::class, $sut, '');
        return $sut;
    }

    public function testItShouldHaveName()
    {
        $sut = $this->makeInstance();
        $this->assertSame(ComponentSubscriberExtension::class, $sut->name());
    }

    public function testItShouldExecute()
    {
        $sut = $this->makeInstance();

        $this->listenerRegister->addListener(
            Argument::type('string'),
            Argument::type('callable'),
            Argument::type('int'),
            Argument::type('int')
        )->shouldBeCalledOnce();

        $sut->execute($this->getAurynConfigInterface());
    }

    public function testItShouldWalk()
    {
        $sut = $this->makeInstance();
        $className = 'ClassName';
        $index_or_optionName = 0;

        $class = $this->prophet->prophesize(Index::class);

        $this->injector->share($className)->willReturn($this->injector);
        $this->injector->proxy($className, Argument::type('callable'))->willReturn($this->injector);
        $this->injector->make($className)->willReturn($class);

        $class->shouldDisplay()->willReturn(true);

        $this->subscriberRegister->addSubscriber($class)->shouldBeCalledOnce();

        $sut($className, $index_or_optionName, $this->getInjector());
    }
}
