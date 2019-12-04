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
use function ItalyStrap\Config\{get_config_file_content};
use function ItalyStrap\Core\{set_default_constants};
use function ItalyStrap\Factory\{get_config, injector};

/**
 * ========================================================================
 *
 * Autoload theme core files.
 *
 * ========================================================================
 */
$autoload_theme_files = [
	'/vendor/autoload.php',
	'/functions/autoload.php',
];

foreach ( $autoload_theme_files as $file ) {
	require_once __DIR__ . '/..' . $file;
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

	$theme_loader = injector()->make( Loader::class );
	$theme_loader->set_dependencies( get_config_file_content( 'dependencies' ) );

	/**
	 * ========================================================================
	 *
	 * Autoload Subscribers Classes
	 *
	 * ========================================================================
	 *
	 * @see _init & _init_admin
	 */
	$subscribers_admin = require '_init_admin.php';
	$subscribers_front = require '_init.php';

	$theme_loader->add_subscribers( $subscribers_admin );
	$theme_loader->add_subscribers( $subscribers_front );

	/**
	 * ========================================================================
	 *
	 * Load the framework
	 *
	 * ========================================================================
	 */
	\add_action( 'italystrap_theme_load', [ $theme_loader, 'load' ] );


	if ( ! isset( $theme_mods ) ) {
		$theme_mods = (array) \get_theme_mods();
	}

	get_config()->merge(
		get_config_file_content( 'default' ),
		$theme_mods,
		$constants
	);

	unset( $theme_mods, $constants );

} catch ( InjectorException $exception ) {
	\_doing_it_wrong( \get_class( injector() ), $exception->getMessage(), '4.0.0' );
} catch ( \Exception $exception ) {
	\_doing_it_wrong( 'General error.', $exception->getMessage(), '4.0.0' );
}

/**
 * This will load the framework after setup theme
 */
\add_action( 'after_setup_theme', function () {

	/**
	 * Injector
	 *
	 * @var \Auryn\Injector
	 */
	$injector = injector();

	/**
	 * Fires before ItalyStrap theme load.
	 *
	 * @since 4.0.0
	 */
	\do_action( 'italystrap_theme_will_load', $injector );

	/**
	 * Fires once ItalyStrap theme is loading.
	 *
	 * @since 4.0.0
	 */
	\do_action( 'italystrap_theme_load', $injector );

	/**
	 * Fires once ItalyStrap theme has loaded.
	 *
	 * @since 4.0.0
	 */
	\do_action( 'italystrap_theme_loaded', $injector );

}, 20 );
