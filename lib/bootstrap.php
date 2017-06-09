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

namespace ItalyStrap\Core;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

/**
 * Autoload theme core files.
 */
$autoload_theme_files = array(
	'/vendor/autoload.php',
	'/functions/default-constants.php',
	'/functions/general-functions.php',

	'/lib/images.php',
	'/lib/pointer.php',
	'/lib/wp-h5bp-htaccess.php', // URL https://github.com/roots/wp-h5bp-htaccess.

	'/deprecated/deprecated.php', // Deprecated files and functions.
);

foreach ( $autoload_theme_files as $file ) {
	require( TEMPLATEPATH . $file );
}

/**
 * This class has to be loaded before the init of all classes.
 *
 * @var \ItalyStrap\Admin\Required_Plugins\Register
 */
$required_plugins = new \ItalyStrap\Required_Plugins\Register;
add_action( 'tgmpa_register', array( $required_plugins, 'init' ) );

/**
 * Set the default theme constant
 *
 * @see /lib/default-constant.php
 */
set_default_constant();

// $italystrap_options = get_option( 'italystrap_theme_settings' ); // DEPRECATED
$italystrap_defaults = apply_filters( 'italystrap_default_theme_config', require( TEMPLATEPATH . '/config/default.php' ) );

if ( ! isset( $theme_mods ) ) {
	$theme_mods = (array) get_theme_mods();
}

$theme_mods = wp_parse_args_recursive( $theme_mods, $italystrap_defaults );

/**
 * Define CURRENT_TEMPLATE and CURRENT_TEMPLATE_SLUG constant.
 * Make shure Router runs after 99998.
 *
 * @see ItalyStrap\Core\set_current_template()
 */
add_filter( 'template_include', __NAMESPACE__ . '\set_current_template', 99998 );

if ( ! isset( $injector ) ) {
	return;
}

/**
 * Define theme_mods parmeter
 */
$injector->defineParam( 'theme_mods', $theme_mods );

/**=======================
 * Autoload Shared Classes
 *======================*/
$autoload_sharing = array(
	'ItalyStrap\Css\Css',
);

/**=============================
 * Autoload Classes definitions
 *============================*/
// $fields_type = array( 'fields_type' => 'ItalyStrap\Fields\Fields' );
$autoload_definitions = array(
	// 'ItalyStrap\Widgets\Attributes\Attributes'	=> $fields_type,
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
	'router'		=> 'ItalyStrap\Router\Router',
	// 'controller'	=> 'ItalyStrap\Core\Router\Controller', // Da testare meglio
	'customizer'	=> 'ItalyStrap\Customizer\Theme_Customizer',
	'css'			=> 'ItalyStrap\Css\Css',
	'init_theme'	=> 'ItalyStrap\Init\Init_Theme',
	'sidebars'		=> 'ItalyStrap\Custom\Sidebars\Sidebars',
	'menu'			=> 'ItalyStrap\Nav_Menu\Register_Nav_Menu_Edit',
	'size'			=> 'ItalyStrap\Custom\Image\Size',
);

require( TEMPLATEPATH . '/lib/_init_admin.php' );
require( TEMPLATEPATH . '/lib/_init.php' );

foreach ( $autoload_sharing as $class ) {
	$injector->share( $class );
}
foreach ( $autoload_definitions as $class_name => $class_args ) {
	$injector->define( $class_name, $class_args );
}
foreach ( $autoload_aliases as $interface => $implementation ) {
	$injector->alias( $interface, $implementation );
}

foreach ( $autoload_concrete as $option_name => $concrete ) {
	$event_manager->add_subscriber( $injector->make( $concrete ) );
}

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
