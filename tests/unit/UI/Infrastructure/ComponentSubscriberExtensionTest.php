<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\UI\Infrastructure;

use ItalyStrap\Empress\Extension;
use ItalyStrap\Event\ListenerRegisterInterface;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\Main\Main;
use ItalyStrap\UI\Infrastructure\ComponentSubscriberExtension;
use Prophecy\Argument;

class ComponentSubscriberExtensionTest extends UnitTestCase
{
    protected function makeInstance(): ComponentSubscriberExtension
    {
        $sut = new ComponentSubscriberExtension($this->makeSubscriberRegister(), $this->makeListenerRegister());
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
        $listenerRegister = new class implements ListenerRegisterInterface {
            public string $eventName = '';
            public $listener = null;
            public int $priority = 0;
            public int $acceptedArgs = 0;

            public function addListener(
                string $eventName,
                callable $listener,
                int $priority = self::PRIORITY,
                int $accepted_args = self::ACCEPTED_ARGS
            ): bool {
                $this->eventName = $eventName;
                $this->listener = $listener;
                $this->priority = $priority;
                $this->acceptedArgs = $accepted_args;

                return true;
            }

            public function removeListener(string $eventName, callable $listener, int $priority): bool
            {
                return true;
            }

            public function removeAllListener(string $eventName, $priority = false): bool
            {
                return true;
            }

            public function hasListener(string $eventName, $callback = false)
            {
                return false;
            }
        };

        $sut = new ComponentSubscriberExtension($this->makeSubscriberRegister(), $listenerRegister);

        $this->aurynConfigInterface->walk(ComponentSubscriberExtension::class, $sut)->shouldBeCalledTimes(2);
        $sut->execute($this->makeAurynConfigInterface());

        $this->assertSame('template_include', $listenerRegister->eventName, '');
        $this->assertIsCallable($listenerRegister->listener);
        $this->assertSame(PHP_INT_MAX - 5, $listenerRegister->priority, '');
        $this->assertSame(ListenerRegisterInterface::ACCEPTED_ARGS, $listenerRegister->acceptedArgs, '');
        $this->assertSame('index.php', ($listenerRegister->listener)('index.php'));
    }

    public function testItShouldWalk()
    {
        $sut = $this->makeInstance();
        $className = 'ClassName';
        $index_or_optionName = 0;

        $class = $this->prophet->prophesize(Main::class);

        $this->injector->share($className)->willReturn($this->injector);
        $this->injector->proxy($className, Argument::type('callable'))->willReturn($this->injector);
        $this->injector->make($className)->willReturn($class);

        $class->shouldDisplay()->willReturn(true);

        $this->subscriberRegister->addSubscriber($class)->shouldBeCalledOnce();

        $sut($className, $index_or_optionName, $this->makeInjector());
    }
}
