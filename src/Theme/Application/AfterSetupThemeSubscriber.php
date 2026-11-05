<?php

declare(strict_types=1);

namespace ItalyStrap\Theme\Application;

use Auryn\Injector;
use ItalyStrap\Event\GlobalDispatcherInterface;
use ItalyStrap\Event\SubscriberInterface;

/**
 * ========================================================================
 *
 * This will load the framework after setup theme
 *
 * ========================================================================
 */
final class AfterSetupThemeSubscriber implements SubscriberInterface
{
    public const AFTER_SETUP_THEME = 'after_setup_theme';

    public function getSubscribedEvents(): iterable
    {
        yield self::AFTER_SETUP_THEME   => [
            SubscriberInterface::CALLBACK   => $this,
            SubscriberInterface::PRIORITY   => 1,
        ];
    }

    public function __construct(private Injector $injector, private GlobalDispatcherInterface $globalDispatcher)
    {
    }

    public function __invoke(): void
    {

        /**
         * Fires before ItalyStrap theme load.
         *
         * @since 4.0.0
         */
        $this->globalDispatcher->trigger('italystrap_theme_will_load', $this->injector);

        /**
         * Fires once ItalyStrap theme is loading.
         *
         * @since 4.0.0
         */
        $this->globalDispatcher->trigger('italystrap_theme_load', $this->injector);

        /**
         * Fires once ItalyStrap theme has loaded.
         *
         * @since 4.0.0
         */
        $this->globalDispatcher->trigger('italystrap_theme_loaded', $this->injector);
    }
}
