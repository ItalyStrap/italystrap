<?php
/**
 * This file init only front-end functionality.
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Core;

use ItalyStrap\Core\Templates\Template_Base as Template;

if ( is_admin() ) {
	return;
}

/**
 * Added for back-compatibility with old hooks
 *
 * @since 4.0.0
 *
 * @var Old_Hooks
 */
$hooks_migrations = new \ItalyStrap\Migrations\Old_Hooks();
$hooks_migrations->convert();

$autoload_classes = array(
	'ItalyStrap\Core\Asset\Asset_Factory',
	'ItalyStrap\Core\Tag_Cloud\Tag_Cloud',
	'ItalyStrap\Core\WooCommerce\WooCommerce',
	'ItalyStrap\Core\WooCommerce\Form_Field',
	'ItalyStrap\Core\Layout\Layout',
);

foreach ( $autoload_classes as $class_name ) {
	$event_manager->add_subscriber( $injector->make( $class_name ) );
}

/**
 * Template object
 *
 * @var Template
 */
$template_settings = new Template( (array) $theme_mods );
// add_filter(
// 	'italystrap_template_include',
// 	array( $template_settings, 'filter_template_include' )
// );

/**
 * Questo filtro si trova nei file template per gestire commenti e altro
 */
add_filter( 'italystrap_template_settings', array( $template_settings, 'get_template_settings' ) );

$template_factory = new \ItalyStrap\Core\Templates\Template_Factory( $theme_mods, $injector, $event_manager );
$registered_classes = $template_factory->register();
// d( $registered_classes );
// $event_manager->remove_subscriber( $registered_classes['italystrap_nav_menu'] );

// add_action( 'wp_enqueue_scripts', function () {
// 	global $wp_filter;
// 	d( $wp_filter['wp_head'] );
// 	remove_action( 'wp_head', 'wp_print_styles', 8 );
// 	remove_action( 'wp_head', 'wp_print_scripts' );
// 	remove_action( 'wp_head', 'wp_print_head_scripts', 9 );
// 	remove_action( 'wp_head', 'wp_enqueue_scripts', 1 );
// 	d( $wp_filter['wp_head'] );
// });

// $event_manager->remove_subscriber( $italystrap_title );
// $injector->execute(function( $args ) use ( $injector ) { d( $injector ); } );
// add_action( 'wp_footer', function () {
// 	$debug_asset = new \ItalyStrap\Debug\Asset_Queued();
// 	$debug_asset->styles();
// 	$debug_asset->scripts();
// }, 100000 );
