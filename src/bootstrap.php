<?php
/**
 * ItalyStrap Bootstrap File
 *
 * @package ItalyStrap
 * @since 4.0.0
 */
declare(strict_types=1);

namespace ItalyStrap;

use Auryn\Injector;
use ItalyStrap\Components\ComponentSubscriberExtension;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Empress\AurynConfig;
use ItalyStrap\Event\SubscriberRegister;
use ItalyStrap\Event\SubscriberRegisterInterface;
use ItalyStrap\Event\SubscribersConfigExtension;
use ItalyStrap\Event\EventDispatcher;
use ItalyStrap\Event\EventDispatcherInterface;
use ItalyStrap\Config\ConfigProviderExtension;
use ItalyStrap\Finder\Finder;
use ItalyStrap\Finder\FinderInterface;
use ItalyStrap\Theme\ExperimentalThemeFileFinderFactory;
use function is_admin;
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
];

foreach ( $autoload_theme_files as $file ) {
	require __DIR__ . DIRECTORY_SEPARATOR . $file;
}

return (static function ( Injector $injector ): Injector {
	$injector
		->alias( EventDispatcherInterface::class, EventDispatcher::class )
		->share( EventDispatcher::class )
		->alias( SubscriberRegisterInterface::class, SubscriberRegister::class )
		->share( SubscriberRegister::class );

	$event_dispatcher = $injector->make( EventDispatcher::class );

	$injector
		->alias(FinderInterface::class, Finder::class)
		->delegate(Finder::class, ExperimentalThemeFileFinderFactory::class)
		->share( FinderInterface::class );

	$finder =  $injector->make( FinderInterface::class );

	$injector_config = $injector->make( AurynConfig::class, [
		':dependencies'	=> (require __DIR__ . '/../config/dependencies.config.php')($finder)
	] );

	$injector_config->extend( $injector->make( ConfigProviderExtension::class ) );
	$injector_config->extend( $injector->make( SubscribersConfigExtension::class ) );
	$injector_config->extend( $injector->make( ComponentSubscriberExtension::class ) );

	/**
	 * ========================================================================
	 *
	 * Load the framework
	 * In this case the priority is at -1 because we have to make sure
	 * everything is loaded, plugins as well.
	 *
	 * ========================================================================
	 */
	$event_dispatcher->addListener( 'after_setup_theme', fn() => $injector_config->resolve(), -1 );
//	$event_dispatcher->addListener(
//		'italystrap_theme_loaded',
//		fn() => \d(
//			$injector->make(ConfigInterface::class)
//		),
//		11
//	);

	/**
	 * ========================================================================
	 *
	 * Load on "wp" event
	 *
	 * ========================================================================
	 */
	! is_admin() && (require __DIR__ . '/../config/front.php')(
		$event_dispatcher,
		$injector->make( ConfigInterface::class )
	);

	/**
	 * So, now in your child theme you can do something like that:
	 * $injector = require \get_template_directory() . '/src/bootstrap.php';
	 *
	 * or even better:
	 * (static function( Injector $injector ) {...do stuff})(require \get_template_directory() . '/src/bootstrap.php');
	 */
	return $injector;
})(injector());
