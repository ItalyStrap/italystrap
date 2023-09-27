<?php

declare(strict_types=1);

namespace ItalyStrap;

use Auryn\Injector;
use ItalyStrap\Config\ConfigProviderExtension;
use ItalyStrap\Customizer\CustomizerProviderExtension;
use ItalyStrap\Empress\AurynConfig;
use ItalyStrap\Event\GlobalOrderedListenerProvider;
use ItalyStrap\Event\SubscribersConfigExtension;
use ItalyStrap\UI\Infrastructure\ComponentSubscriberExtension;

use function ItalyStrap\Factory\injector;

require __DIR__ . DIRECTORY_SEPARATOR . '../vendor/autoload.php';

return (static function (Injector $injector): Injector {
    $injectorConfig = $injector->make(AurynConfig::class, [
        ':dependencies' => (require __DIR__ . '/../config/dependencies.config.php')($injector)
    ]);

    $injectorConfig->extendFromClassName(ConfigProviderExtension::class);
    $injectorConfig->extendFromClassName(SubscribersConfigExtension::class);
    $injectorConfig->extendFromClassName(ComponentSubscriberExtension::class);
    $injectorConfig->extendFromClassName(CustomizerProviderExtension::class);

    $listenerProvider = $injector->make(GlobalOrderedListenerProvider::class);

    /**
     * ========================================================================
     *
     * Load the framework
     * In this case the priority is at -1 because we have to make sure
     * everything is loaded, plugins as well.
     *
     * ========================================================================
     */
    $listenerProvider->addListener('after_setup_theme', fn() => $injectorConfig->resolve(), -1);

    /**
     * So, now in your child theme you can do something like that:
     * $injector = require \get_template_directory() . '/src/bootstrap.php';
     *
     * or even better:
     * (static function( Injector $injector ) {...do stuff})(require \get_template_directory() . '/src/bootstrap.php');
     */
    return $injector;
})(injector());
