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
use ItalyStrap\Components\ComponentSubscriber;
use ItalyStrap\Empress\AurynConfig;
use ItalyStrap\Event\SubscriberRegister;
use ItalyStrap\Event\SubscriberRegisterInterface;
use ItalyStrap\Event\SubscribersConfigExtension;
use ItalyStrap\Event\EventDispatcher;
use ItalyStrap\Event\EventDispatcherInterface;
use ItalyStrap\Finder\Finder;
use ItalyStrap\Finder\FinderInterface;
use ItalyStrap\Theme\ExperimentalThemeFileFinderFactory;
use ItalyStrap\Theme\License;
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
	 * ========================================================================
	 *
	 * Define CURRENT_TEMPLATE and CURRENT_TEMPLATE_SLUG constant.
	 *
	 * @see \ItalyStrap\Core\set_current_template_constants()
	 *
	 * ========================================================================
	 */
//		$event_dispatcher->addListener(
//			'template_include',
//			'\ItalyStrap\Core\set_current_template_constants',
//			PHP_INT_MAX - 100
//		);

	/**
	 * Constants must be merged before default
	 * because in default there is a call for get_config
	 * @TODO Remove get_config() dependency from inside the default array
	 */
	get_config()->merge(
		$constants,
		get_config_file_content( 'default' ),
		(array) get_theme_mods()
	);

	$injector_config = $injector->make( AurynConfig::class, [
		':dependencies'	=> (require __DIR__ . '/../config/dependencies.config.php')($finder)
	] );

	$injector_config->extend( $injector->make( SubscribersConfigExtension::class ) );
	$injector_config->extend( $injector->make( ComponentSubscriber::class ) );

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
})(injector());
