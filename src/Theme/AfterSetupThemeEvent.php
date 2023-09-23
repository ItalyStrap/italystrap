<?php

declare(strict_types=1);

namespace ItalyStrap\Theme;

use Auryn\Injector;
use ItalyStrap\Event\EventDispatcherInterface;
use ItalyStrap\Event\SubscriberInterface;

/**
 * ========================================================================
 *
 * This will load the framework after setup theme
 *
 * ========================================================================
 */
final class AfterSetupThemeEvent implements SubscriberInterface
{
    const AFTER_SETUP_THEME = 'after_setup_theme';

    private EventDispatcherInterface $dispatcher;
    private Injector $injector;

    public function getSubscribedEvents(): iterable
    {
        yield self::AFTER_SETUP_THEME   => [
            SubscriberInterface::CALLBACK   => $this,
            SubscriberInterface::PRIORITY   => 1,
        ];
    }

    public function __construct(Injector $injector, EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
        $this->injector = $injector;
    }

    public function __invoke(): void
    {

        /**
         * Fires before ItalyStrap theme load.
         *
         * @since 4.0.0
         */
        $this->dispatcher->trigger('italystrap_theme_will_load', $this->injector);

        /**
         * Fires once ItalyStrap theme is loading.
         *
         * @since 4.0.0
         */
        $this->dispatcher->trigger('italystrap_theme_load', $this->injector);

        /**
         * Fires once ItalyStrap theme has loaded.
         *
         * @since 4.0.0
         */
        $this->dispatcher->trigger('italystrap_theme_loaded', $this->injector);
    }
}
