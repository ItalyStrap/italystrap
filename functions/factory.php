<?php

/**
 * Get the Injector instance
 */

declare(strict_types=1);

namespace ItalyStrap\Factory;

use Auryn\ConfigException;
use Auryn\Injector as AurynInjector;
use ItalyStrap\Debug\Injector as DebugInjector;

use function ItalyStrap\Core\is_debug;

if (!function_exists('\ItalyStrap\Factory\injector')) {

    /**
     * @return AurynInjector
     * @throws ConfigException
     */
    function injector(): AurynInjector
    {

        /**
         * Injector from ACM if is active
         */
        $injector = apply_filters('italystrap_injector', false);

        if (!$injector) {
            $injector = new AurynInjector();
            $injector->share($injector);
            add_filter('italystrap_injector', function () use ($injector) {
                return $injector;
            });
        }

        if (!is_debug()) {
            return $injector;
        }

        if (!($injector instanceof AurynInjector)) {
            $injector = new DebugInjector($injector);
            $injector->alias(AurynInjector::class, DebugInjector::class);
            $injector->share($injector);
            add_filter('italystrap_injector', function () use ($injector) {
                return $injector;
            });
        }

        return $injector;
    }
}
