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
use ItalyStrap\Config;
use ItalyStrap\Core;

/** =========================
 * Autoload theme core files.
 ========================== */
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
	$event_manager = $injector->make( '\ItalyStrap\Event\Manager' );
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

foreach ( $dependencies['sharing'] as $class ) {
	try {
		$injector->share( $class );
	} catch ( ConfigException $exception ) {
		echo $exception->getMessage();
	} catch ( \Exception $exception ) {
		echo $exception->getMessage();
	}
}

foreach ( $dependencies['aliases'] as $interface => $implementation ) {
	try {
		$injector->alias( $interface, $implementation );
	} catch ( ConfigException $exception ) {
		echo $exception->getMessage();
	} catch ( \Exception $exception ) {
		echo $exception->getMessage();
	}
}

foreach ( $dependencies['definitions'] as $class_name => $class_args ) {
	$injector->define( $class_name, $class_args );
}

foreach ( $dependencies['define_param'] as $param_name => $param_args ) {
	$injector->defineParam( $param_name, $param_args );
}

foreach ( $dependencies['delegations'] as $name => $callableOrMethodStr ) {
	try {
		$injector->delegate( $name, $callableOrMethodStr );
	} catch ( ConfigException $exception ) {
		echo $exception->getMessage();
	} catch ( \Exception $exception ) {
		echo $exception->getMessage();
	}
}

foreach ( $dependencies['preparations'] as $class => $callable ) {
	try {
		$injector->prepare( $class, $callable );
	} catch ( InjectionException $exception ) {
		echo $exception->getMessage();
	} catch ( \Exception $exception ) {
		echo $exception->getMessage();
	}
}
foreach ( $dependencies['execute'] as $callableOrMethodStr => $args ) {
	d( $callableOrMethodStr, $args );
//	try {
//		$injector->execute( $callableOrMethodStr, $args );
//	} catch ( InjectionException $exception ) {
//		echo $exception->getMessage();
//	} catch ( \Exception $exception ) {
//		echo $exception->getMessage();
//	}
}
/**
 * ========================================================================
 * Autoload Concrete Classes
 * ========================================================================
 *
 * @see _init & _init_admin
 */
$autoload_concrete = array(
	'ItalyStrap\Router\Router',
	// 'ItalyStrap\Core\Router\Controller', // Da testare meglio
	'ItalyStrap\Customizer\Theme_Customizer',
	'ItalyStrap\Css\Css',
	'ItalyStrap\Init\Init_Theme', // 'italystrap_plugin_app_loaded'
	'ItalyStrap\Custom\Sidebars\Sidebars',
	'ItalyStrap\Nav_Menu\Register_Nav_Menu_Edit',
	'ItalyStrap\Custom\Image\Size', // 'italystrap_plugin_app_loaded'
);

require '_init_admin.php';
require '_init.php';

//$args = [];
//$concrete_example = [
//	'ItalyStrap\Router\Router', // String
//	'ItalyStrap\Router\Router'	=> $args, // String
//	'option'	=> 'ItalyStrap\Router\Router',
//	'option2'	=> [
//		'name'	=> 'ItalyStrap\Router\Router',
//		'args'	=> $args,
//	],
//];

foreach ( $dependencies['concretes'] as $option_name => $concrete ) {
	if ( method_exists( $concrete, 'get_subscribed_events' ) ) {
		$event_manager->add_subscriber( $injector->make( $concrete ) );
	} else {
		$injector->make( $concrete );
	}
}

/**
 * Loaded on after_setup_themes in the ACM plugin
 */
add_filter( 'italystrap_app', function ( $app ) use ( $autoload_concrete, $config ) {

	$app['subscribers'] = array_merge( $app['subscribers'], $autoload_concrete );

	return $app;

}, 10, 1 );

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

}, 99 );
