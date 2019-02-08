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
 */

namespace ItalyStrap;

use Auryn\Injector;
use ItalyStrap\Core;

/** =========================
 * Autoload theme core files.
 ========================== */
$autoload_theme_files = [
	'/vendor/autoload.php',
	'/functions/default-constants.php',
	'/functions/general-functions.php',
	'/functions/config-helpers.php',
	'/functions/italystrap.php',

	'/lib/images.php',
	'/lib/pointer.php',
	'/lib/edd.php',
];

if ( apply_filters( 'italystrap_load_deprecated', false ) ) {
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
 * This class has to be loaded before the init of all classes.
 *
 * @var \ItalyStrap\Admin\Required_Plugins\Register
 */
// add_action( 'after_setup_theme', function() use ( $required_plugins ) {
// 	$required_plugins = new \ItalyStrap\Required_Plugins\Register;
// 	add_action( 'tgmpa_register', array( $required_plugins, 'init' ) );
// }, 10, 1 );

/**
 * Set the default theme constant
 *
 * @see /lib/default-constant.php
 */
$constants = Core\set_default_constant( require __DIR__ . '/../config/constants.php' );

/**
 * Define CURRENT_TEMPLATE and CURRENT_TEMPLATE_SLUG constant.
 * Make sure Router runs after 99998.
 *
 * @see \ItalyStrap\Core\set_current_template()
 */
add_filter( 'template_include', '\ItalyStrap\Core\set_current_template', 99998 );

/**
 * Defined here after the set_default_constant()
 */
$all_config_files_path = (array) Config\get_config_files();

$italystrap_defaults = apply_filters(
	'italystrap_default_theme_config',
	require $all_config_files_path[ 'default' ]
);

if ( ! isset( $theme_mods ) ) {
	$theme_mods = (array) get_theme_mods();
}

// https://core.trac.wordpress.org/ticket/24844
// if ( is_customize_preview() ) {
// 	foreach ( $theme_mods as $key => $value ) {
// 		$theme_mods[ $key ] = apply_filters( 'theme_mod_' . $key, $value );
// 	}
// }

$theme_mods = Core\wp_parse_args_recursive( $theme_mods, $italystrap_defaults );

$theme_supports = require PARENTPATH . '/config/theme-supports.php';

$theme_config = array_merge( $theme_mods, $constants, $theme_supports );

/**
 * Injector from ACM if is active
 */
//$injector = apply_filters( 'italystrap_injector', null );
//
//if ( ! isset( $injector ) ) {
//	$injector = new Injector();
//	add_filter( 'italystrap_injector', function () use ( $injector ) {
//		return $injector;
//	} );
//}

add_action( 'italystrap_theme_will_load', function () use ( $injector, $theme_config ) {

	$args = [
		':array_to_merge' => $theme_config,
	];

	$injector->execute( '\ItalyStrap\Config\merge_array_to_config', $args );
} );

/**
 * Define theme_mods parmeter
 */
// $injector->defineParam( 'theme_mods', $theme_mods );

/**=======================
 * Autoload Shared Classes
 *======================*/
$autoload_sharing = array(
	'ItalyStrap\Css\Css',
);

/**=============================
 * Autoload Classes definitions
 *============================*/
$autoload_definitions = array(
//	'ItalyStrap\Init\Init_Theme'	=> [
//		':theme_supports'	=> require PARENTPATH . '/config/theme-supports.php',
//	],
);

/**======================
 * Autoload Aliases Class
 *=====================*/
$autoload_aliases = array(
	// 'ItalyStrap\Config\Config_Interface'	=> 'ItalyStrap\Config\Config',
);

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
//	'ItalyStrap\EDD\Theme_Updater_Factory',
);

require '_init_admin.php';
require '_init.php';

// foreach ( $autoload_sharing as $class ) {
// 	$injector->share( $class );
// }
// foreach ( $autoload_definitions as $class_name => $class_args ) {
// 	$injector->define( $class_name, $class_args );
// }
// foreach ( $autoload_aliases as $interface => $implementation ) {
// 	$injector->alias( $interface, $implementation );
// }

// foreach ( $autoload_concrete as $option_name => $concrete ) {
// 	$event_manager->add_subscriber( $injector->make( $concrete ) );
// }

add_action( 'init', function() use ( $theme_mods ) {
	foreach ( $theme_mods['post_type_support'] as $post_type => $features ) {
		add_post_type_support( $post_type, $features );
	}
});

/**
 * $content_width is a global variable used by WordPress for max image upload sizes
 * and media embeds (in pixels).
 *
 * Example: If the content area is 640px wide,
 * set $content_width = 620; so images and videos will not overflow.
 * Default: 750px is the default ItalyStrap container width.
 */
if ( ! isset( $content_width ) ) {
	$content_width = apply_filters( 'italystrap_content_width', $theme_mods['content_width'] );
}

add_filter( 'italystrap_app', function ( $app ) use ( $autoload_concrete, $autoload_definitions, $theme_mods ) {

	$app['definitions'] = array_merge( $app['definitions'], $autoload_definitions );

	$app['sharing'][] = 'ItalyStrap\Css\Css';

	$app['define_param']['theme_mods'] = $theme_mods;

	if ( isset( $app['definitions']['ItalyStrap\Config\Config'][':config'] ) ) {
		$app['definitions']['ItalyStrap\Config\Config'][':config'] = array_merge( $app['definitions']['ItalyStrap\Config\Config'][':config'], $theme_mods );
	}

	$app['subscribers'] = array_merge( $app['subscribers'], $autoload_concrete );

	return $app;
}, 10, 1 );

/**
 * Fires once ItalyStrap theme has loaded.
 *
 * @since 2.0.0
 */
do_action( 'italystrap_theme_will_load' );

	/**
	 * Fires once ItalyStrap theme is loading.
	 *
	 * @since 2.0.0
	 */
	do_action( 'italystrap_theme_load' );

/**
 * Fires once ItalyStrap theme has loaded.
 *
 * @since 2.0.0
 */
do_action( 'italystrap_theme_loaded' );

/**
 * This filter is used to load your php file right after ItalyStrap theme is loaded.
 * The purpose is to have al code in the same scope without using global
 * with variables provided from this theme.
 *
 * Usage example:
 *
 * 1 - First of all you have to have the file/files with some code
 *     that extending this themes functionality in your theme path.
 * 2 - Than you have to activate your theme.
 * 3 - And then see the below example.
 *
 * add_filter( 'italystrap_require_theme_files_path', 'add_your_files_path' );
 *
 * function add_your_files_path( array $arg ) {
 *     return array_merge(
 *                  $arg,
 *                  array( STYLESHEETPATH . 'my-dir/my-file.php' )
 *     );
 * }
 * Important:
 * Remeber that the file you want to load just after ItalyStrap theme
 * has not to be required/included from your theme because
 * you will get an error 'You can't redeclare...'.
 *
 * @since 2.0.0
 *
 * @var array
 */
$theme_files_path = apply_filters( 'italystrap_require_theme_files_path', array() );

if ( ! empty( $theme_files_path ) ) {
	foreach ( (array) $theme_files_path as $key => $theme_file_path ) {
		require $theme_file_path ;
	}
	/**
	 * Fires once ItalyStrap Child theme has loaded.
	 *
	 * @since 2.0.0
	 */
	do_action( 'italystrap_child_theme_loaded' );
}
