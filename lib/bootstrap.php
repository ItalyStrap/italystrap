<?php
/**
 * ItalyStrap Bootstrap File
 *
 * This is the bootstrap file for all core and admin Class and Functions.
 *
 * Da leggere:
 * http://mikejolley.com/2013/12/15/deprecating-plugin-functions-hooks-woocommmerce/
 *
 * @package ItalyStrap
 * @since 4.0.0
 *
 * @TODO https://github.com/understrap/understrap/issues/585
 */

namespace ItalyStrap;

use Auryn\Injector;
use Auryn\ConfigException;
use Auryn\InjectionException;
use Auryn\InjectorException;
use ItalyStrap\Config;
use ItalyStrap\Core;

/**
 * ==========================
 *
 * Autoload theme core files.
 *
 * ==========================
 */
$autoload_theme_files = [
	'/vendor/autoload.php',
	'/functions/default-constants.php',
	'/functions/general-functions.php',
	'/functions/config-helpers.php',
	'/functions/comments-helpers.php',
	'/functions/italystrap.php',

	'/lib/images.php',
	'/lib/pointer.php',
	'/lib/edd.php',
];

if ( apply_filters( 'italystrap_load_deprecated', true ) ) {
	$autoload_theme_files[] = '/deprecated/deprecated.php';
}

foreach ( $autoload_theme_files as $file ) {
	require __DIR__ . '/..' . $file;
}

/**
 * Injector from ACM if is active
 */
$injector = apply_filters( 'italystrap_injector', null );

if ( ! isset( $injector ) ) {
	$injector = new Injector();
	add_filter( 'italystrap_injector', function () use ( $injector ) {
		return $injector;
	} );
}

/**
 * Set the default theme constant
 *
 * @see /config/constants.php
 */
$constants = Core\set_default_constant( Config\get_config_file_content( 'constants' ) );

/**
 * Define CURRENT_TEMPLATE and CURRENT_TEMPLATE_SLUG constant.
 * Make sure Router runs after 99998.
 *
 * @see \ItalyStrap\Core\set_current_template()
 */
add_filter( 'template_include', '\ItalyStrap\Core\set_current_template', 99998 );

if ( ! isset( $theme_mods ) ) {
	$theme_mods = (array) get_theme_mods();
}

$theme_mods = Core\wp_parse_args_recursive( $theme_mods, Config\get_config_file_content( 'default' ) );

$theme_supports = Config\get_config_file_content( 'theme-supports' );

//$theme_config = array_merge( $theme_mods, $constants, $theme_supports );

try {
//	$event_manager = $injector->make( '\ItalyStrap\Event\Manager' );
	$config = $injector->make( '\ItalyStrap\Config\Config' );
	$config->merge( $theme_mods );
	$config->merge( $constants );
	$config->merge( $theme_supports );
} catch ( InjectionException $exception ) {
	echo $exception->getMessage();
} catch ( \Exception $exception ) {
	echo $exception->getMessage();
}

//add_action( 'italystrap_theme_will_load', function ( Injector $injector ) use ( $theme_config ) {
//
//	$args = [
//		':array_to_merge' => $theme_config,
//	];
//
//	$injector->execute( '\ItalyStrap\Config\merge_array_to_config', $args );
//
//} );

/**
 * @var array $dependencies
 */
$dependencies = Config\get_config_file_content( 'dependencies' );

/**
 * ========================================================================
 * Autoload Concrete Classes
 * ========================================================================
 *
 * @see _init & _init_admin
 */
$autoload_concrete = $dependencies['concretes'];

$dependencies_admin = require '_init_admin.php';
$dependencies_front = require '_init.php';

//$dependencies['concretes'] = $autoload_concrete;

try {
	$theme_loader = $injector->make( 'ItalyStrap\Theme_Test_Load' );

	$theme_loader->set_dependencies( $dependencies );
	$theme_loader->add_concretes( $dependencies_admin );
	$theme_loader->add_concretes( $dependencies_front );

//	$theme_loader->before( $injector );

	add_action( 'italystrap_theme_load', [ $theme_loader, 'load' ] );

} catch ( InjectorException $exception ) {
	echo $exception->getMessage();
} catch ( \Exception $exception ) {
	echo $exception->getMessage();
}

/**
 * Loaded on after_setup_themes in the ACM plugin
 */
//add_filter( 'italystrap_app', function ( $app ) use ( $autoload_concrete, $config ) {

//	$app['subscribers'] = array_merge( $app['subscribers'], $autoload_concrete );

//	return $app;

//}, 10, 1 );

/**
 * $content_width is a global variable used by WordPress for max image upload sizes
 * and media embeds (in pixels).
 *
 * Example: If the content area is 640px wide,
 * set $content_width = 620; so images and videos will not overflow.
 * Default: 750px is the default ItalyStrap container width.
 */
if ( ! isset( $content_width ) ) {
	$content_width = apply_filters( 'italystrap_content_width', $config->get( 'content_width' ) );
}

add_action( 'after_setup_theme', function () {

	/**
	 * Injector from ACM if is active
	 */
	$injector = apply_filters( 'italystrap_injector', null );

	/**
	 * Fires before ItalyStrap theme load.
	 *
	 * @since 2.0.0
	 */
	do_action( 'italystrap_theme_will_load', $injector );

	/**
	 * Fires once ItalyStrap theme is loading.
	 *
	 * @since 2.0.0
	 */
	do_action( 'italystrap_theme_load', $injector );

	/**
	 * Fires once ItalyStrap theme has loaded.
	 *
	 * @since 2.0.0
	 */
	do_action( 'italystrap_theme_loaded', $injector );

}, 20 );
