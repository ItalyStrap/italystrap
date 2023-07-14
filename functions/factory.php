<?php

/**
 * Get the Injector instance
 */

declare(strict_types=1);

namespace ItalyStrap\Factory;

use Auryn\ConfigException;
use Auryn\InjectionException;
use Auryn\Injector as AurynInjector;
use Exception;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Debug\Injector as DebugInjector;
use ItalyStrap\Empress\Injector as EmpressInjector;
use ItalyStrap\Config\Config;
use ItalyStrap\View\View;

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
            $injector = new EmpressInjector();
            $injector->alias(AurynInjector::class, EmpressInjector::class);
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
