<?php
/**
 * ItalyStrap Bootstrap File
 *
 * This is the bootstrapping file for the ItalyStrap framework.
 *
 *
 * @package ItalyStrap
 * @since 4.0.0
 */
declare(strict_types=1);

namespace ItalyStrap;

use Auryn\Injector;
use Auryn\InjectorException;
use ItalyStrap\Config\ConfigFactory;
use ItalyStrap\Empress\AurynConfig;
use ItalyStrap\Event\SubscriberRegister;
use ItalyStrap\Event\SubscribersConfigExtension;
use ItalyStrap\Event\EventDispatcher;
use ItalyStrap\Event\EventDispatcherInterface;
use ItalyStrap\Theme\License;
use Throwable;
use function get_theme_mods;
use function is_admin;
use function ItalyStrap\Config\get_config_file_content;
use function ItalyStrap\Core\set_default_constants;
use function ItalyStrap\Factory\get_config;
use function ItalyStrap\Factory\injector;

/**
 * ========================================================================
 *
 * Autoload theme core files.
 *
 * ========================================================================
 */
$autoload_theme_files = [
	'../vendor/autoload.php',
	'../functions/autoload.php',
];

foreach ( $autoload_theme_files as $file ) {
	require __DIR__ . DIRECTORY_SEPARATOR . $file;
}

return (static function (): Injector {
//    try {
		$injector = injector();

		$injector
			->alias( EventDispatcherInterface::class, EventDispatcher::class )
			->share( EventDispatcher::class )
			->share( SubscriberRegister::class );

		/**
		 * ========================================================================
		 *
		 * Set the default theme constant
		 *
		 * @see /config/constants.php
		 *
		 * @var array $constants
		 *
		 * ========================================================================
		 */
		$constants = set_default_constants( get_config_file_content( 'constants' ) );

		/**
		 * Constants must be merged before default
		 * because in default there is a call for get_config
		 * @TODO Remove get_config() dependency from inside the default array
		 */
		//	get_config()->merge($constants);

		get_config()->merge(
			$constants,
			get_config_file_content( 'default' ),
			$theme_mods ?? (array) get_theme_mods()
		);

		unset( $theme_mods, $constants );

		/** @var callable $dependencies_collection */
		$dependencies_collection = require __DIR__ . '/../config/dependencies.aggregator.php';

		$injector_config = $injector->make( AurynConfig::class, [
			':dependencies'	=> ConfigFactory::make($dependencies_collection())
		] );

		$injector_config->extend( $injector->make( SubscribersConfigExtension::class ) );

		$event_dispatcher = $injector->make( EventDispatcher::class );

		/**
		 * Register the license for this theme
		 */
		( $injector->make( License::class ) )->register();

		/**
		 * ========================================================================
		 *
		 * Load the framework
		 *
		 * ========================================================================
		 */
		$event_dispatcher->addListener( 'italystrap_theme_load', fn() => $injector_config->resolve() );

		! is_admin() && (require __DIR__ . '/../config/front.php')($event_dispatcher, get_config());

		/**
		 * ========================================================================
		 *
		 * This will load the framework after setup theme
		 *
		 * ========================================================================
		 */
		(require __DIR__ . '/../config/after.setup.theme.php')($injector, $event_dispatcher);

		/**
		 * So, now in your child theme you can do something like that:
		 * $injector = require get_template_directory() . '/src/bootstrap.php';
		 */
		return $injector;
//    } catch ( InjectorException $exception ) {
//        var_dump($exception);
//        \_doing_it_wrong( \get_class( injector() ), $exception->getMessage(), \ITALYSTRAP_THEME_VERSION );
//    } catch ( Throwable $exception ) {
//        var_dump($exception);
//        \_doing_it_wrong( 'General error.', $exception->getMessage(), \ITALYSTRAP_THEME_VERSION );
//    }
})();
