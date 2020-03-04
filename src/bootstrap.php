<?php
/**
 * ItalyStrap Bootstrap File
 *
 * This is the bootstrapping for the ItalyStrap framework.
 *
 *
 * @package ItalyStrap
 * @since 4.0.0
 *
 * @TODO https://github.com/understrap/understrap/issues/585
 */
declare(strict_types=1);

namespace ItalyStrap;

use Auryn\InjectorException;
use ItalyStrap\Config\ConfigFactory;
use ItalyStrap\Empress\AurynResolver;
use ItalyStrap\Empress\Injector;
use ItalyStrap\Event\SubscriberRegister;
use ItalyStrap\Event\EventResolverExtension;
use ItalyStrap\Event\EventDispatcher;
use ItalyStrap\Event\EventDispatcherInterface;
use Throwable;
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

/**
 * Set the default theme constant
 *
 * @see /config/constants.php
 *
 * @var array $constants
 */
$constants = set_default_constants( get_config_file_content( 'constants' ) );

/**
 * This need to be set as soon as possible
 */
get_config()->merge( $constants );

/**
 * ========================================================================
 *
 * Define CURRENT_TEMPLATE and CURRENT_TEMPLATE_SLUG constant.
 * Make sure Router runs after 99998.
 *
 * @see \ItalyStrap\Core\set_current_template_constants()
 *
 * ========================================================================
 */
\add_filter( 'template_include', '\ItalyStrap\Core\set_current_template_constants', 99998 );

try {
	$injector = injector();
	$injector = new DebugInjector( $injector );
	$injector->share( $injector );

	$injector->alias(EventDispatcherInterface::class, EventDispatcher::class);
	$injector->share( EventDispatcherInterface::class );
	$injector->share( SubscriberRegister::class );

	$event_resolver = $injector->make( EventResolverExtension::class, [
		':config'	=> get_config(),
	] );

	$dependence_collection = get_config_file_content( 'dependencies' );
	$dependence_collection[ EventResolverExtension::SUBSCRIBERS ] = \array_merge(
		$dependence_collection[ EventResolverExtension::SUBSCRIBERS ],
		get_config_file_content( 'dependencies-admin' ),
		get_config_file_content( 'dependencies-front' )
	);

	$dependencies = ConfigFactory::make($dependence_collection);

	$empress = $injector->make( AurynResolver::class, [
		':dependencies'	=> $dependencies
	] );

	$empress->extend( $event_resolver );

	$event_dispatcher = $injector->make( EventDispatcher::class );

	/**
	 * ========================================================================
	 *
	 * Load the framework
	 *
	 * ========================================================================
	 */
	$event_dispatcher->addListener( 'italystrap_theme_load', function () use ( $empress ) {
		$empress->resolve();
	} );

	if ( ! isset( $theme_mods ) ) {
		$theme_mods = (array) \get_theme_mods();
	}

	get_config()->merge(
		get_config_file_content( 'default' ),
		$theme_mods
	);

	unset( $theme_mods, $constants );

/**
 * This will load the framework after setup theme
 */
$event_dispatcher->addListener( 'after_setup_theme', function () use ( $injector, $event_dispatcher ) {

	/**
	 * Fires before ItalyStrap theme load.
	 *
	 * @since 4.0.0
	 */
	$event_dispatcher->execute( 'italystrap_theme_will_load', $injector );

	/**
	 * Fires once ItalyStrap theme is loading.
	 *
	 * @since 4.0.0
	 */
	$event_dispatcher->execute( 'italystrap_theme_load', $injector );

	/**
	 * Fires once ItalyStrap theme has loaded.
	 *
	 * @since 4.0.0
	 */
	$event_dispatcher->execute( 'italystrap_theme_loaded', $injector );
}, 20 );

} catch ( InjectorException $exception ) {
	\_doing_it_wrong( \get_class( injector() ), $exception->getMessage(), '4.0.0' );
} catch ( Throwable $exception ) {
	\_doing_it_wrong( 'General error.', $exception->getMessage(), '4.0.0' );
}
