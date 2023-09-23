<?php

declare(strict_types=1);

namespace ItalyStrap\Customizer;

use ItalyStrap\Empress\AurynConfigInterface;
use ItalyStrap\Empress\Injector;
use ItalyStrap\Event\ListenerRegisterInterface;

class CustomizerProviderExtension implements \ItalyStrap\Empress\Extension
{
    private ListenerRegisterInterface $listenerRegister;
    private Injector $injector;

    public function __construct(
        ListenerRegisterInterface $listenerRegister,
        Injector                 $injector
    ) {
        $this->listenerRegister = $listenerRegister;
        $this->injector = $injector;
    }

    /**
     * @inheritDoc
     */
    public function name(): string
    {
        return self::class;
    }

    /**
     * @inheritDoc
     */
    public function execute(AurynConfigInterface $application): void
    {
        $this->listenerRegister->addListener('customize_register', $this->buildCallable($application), 99, 3);
    }

    public function __invoke(string $class, $index_or_optionName, Injector $injector): void
    {
        $object = $injector->make($class);
        if (\is_callable($object)) {
            $injector->execute($object);
        }
    }

    private function buildCallable(AurynConfigInterface $application): callable
    {
        return function (\WP_Customize_Manager $manager) use ($application): void {
            $this->injector->share($manager);
            $application->walk($this->name(), $this);
        };
    }
}
