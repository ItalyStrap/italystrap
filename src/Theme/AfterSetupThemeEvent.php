<?php

declare(strict_types=1);

namespace ItalyStrap\Theme;

use Auryn\Injector;
use ItalyStrap\Event\EventDispatcher;
use ItalyStrap\Event\SubscriberInterface;

/**
 * ========================================================================
 *
 * This will load the framework after setup theme
 *
 * ========================================================================
 */
final class AfterSetupThemeEvent implements Registrable, SubscriberInterface
{
    private EventDispatcher $dispatcher;
    private Injector $injector;

    public function getSubscribedEvents(): iterable
    {
        yield 'after_setup_theme'   => [
            SubscriberInterface::CALLBACK   => Registrable::REGISTER_CB,
            SubscriberInterface::PRIORITY   => 1,
        ];
    }

    public function __construct(Injector $injector, EventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
        $this->injector = $injector;
    }

    /**
     * @return void
     */
    public function register()
    {

        /**
         * Fires before ItalyStrap theme load.
         *
         * @since 4.0.0
         */
        $this->dispatcher->dispatch('italystrap_theme_will_load', $this->injector);

        /**
         * Fires once ItalyStrap theme is loading.
         *
         * @since 4.0.0
         */
        $this->dispatcher->dispatch('italystrap_theme_load', $this->injector);

        /**
         * Fires once ItalyStrap theme has loaded.
         *
         * @since 4.0.0
         */
        $this->dispatcher->dispatch('italystrap_theme_loaded', $this->injector);
    }
}
