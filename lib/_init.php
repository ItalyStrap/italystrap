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

if ( is_admin() ) {
	return;
}

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
$template_settings = $injector->make( 'ItalyStrap\Core\Templates\Template_Base' );
//Questo filtro si trova nei file template per gestire commenti e altro
add_filter( 'italystrap_template_settings', array( $template_settings, 'get_template_settings' ) );

$template_factory = new \ItalyStrap\Core\Templates\Template_Factory( $theme_mods, $injector, $event_manager );
$registered_classes = $template_factory->register();

/**
 * Added for back-compatibility with old hooks
 *
 * @since 4.0.0
 *
 * @var Old_Hooks
 */
// $hooks_migrations = new \ItalyStrap\Migrations\Old_Hooks();
$hooks_migrations = $injector->make( 'ItalyStrap\Migrations\Old_Hooks' );
$hooks_migrations->convert();
