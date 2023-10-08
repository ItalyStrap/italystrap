<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Infrastructure;

use ItalyStrap\Empress\AurynConfigInterface;
use ItalyStrap\Empress\Extension;
use ItalyStrap\Empress\Injector;
use ItalyStrap\Empress\ProxyFactory;
use ItalyStrap\Event\ListenerRegisterInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Event\SubscriberRegisterInterface;
use ItalyStrap\UI\Components\ComponentInterface;

class ComponentSubscriberExtension implements Extension
{
    private ListenerRegisterInterface $listenerRegister;
    private SubscriberRegisterInterface $subscriberRegister;
    private ProxyFactory $proxy;

    public function __construct(
        SubscriberRegisterInterface $subscriberRegister,
        ListenerRegisterInterface $listenerRegister
    ) {
        $this->subscriberRegister = $subscriberRegister;
        $this->listenerRegister = $listenerRegister;
        $this->proxy = new ProxyFactory();
    }

    public function name(): string
    {
        return self::class;
    }

    public function execute(AurynConfigInterface $application)
    {
//        $listeners = [
//            'template_include',
//            'enqueue_block_editor_assets',
//        ];
//
//        foreach ($listeners as $listener) {
//            $this->listenerRegister->addListener(
//                $listener,
//                function (string $current_template = '') use ($application): string {
//                    $application->walk($this->name(), $this);
//                    return $current_template;
//                },
//                PHP_INT_MAX - 5
//            );
//        }
//
        $application->walk($this->name(), $this);

        $this->listenerRegister->addListener(
            'template_include',
            function (string $current_template = '') use ($application): string {
                $application->walk($this->name(), $this);
                return $current_template;
            },
            PHP_INT_MAX - 5
        );
    }

    public function __invoke(string $class, $index_or_optionName, Injector $injector): void
    {
        /** @var SubscriberInterface|ComponentInterface $instance */
        $instance = $injector
            ->share($class)
            ->proxy($class, $this->proxy)
            ->make($class);

        if ($this->shouldNotDisplay($instance)) {
            return;
        }

        $this->subscriberRegister->addSubscriber($instance);
    }

    private function shouldNotDisplay(ComponentInterface $instance): bool
    {
        return ! $instance->shouldDisplay();
    }
}
