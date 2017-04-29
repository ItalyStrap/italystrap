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

$autoload_concrete = array_merge( $autoload_concrete, array(
	'ItalyStrap\Core\Asset\Asset_Factory',
	'ItalyStrap\Core\Tag_Cloud\Tag_Cloud',
	'ItalyStrap\Core\WooCommerce\WooCommerce',
	'ItalyStrap\Core\WooCommerce\Form_Field',
	'ItalyStrap\Core\Layout\Layout',
) );

/* Questo filtro si trova nei file template per gestire commenti e breadcrumbs */
add_filter( 'italystrap_template_settings', function ( $array ) {
	return (array) get_post_meta( get_queried_object_id(), '_italystrap_template_settings', true );
} );

$template_factory = new \ItalyStrap\Core\Templates\Template_Factory( $theme_mods, $injector, $event_manager );
$template_factory->register();

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

use ItalyStrap\Core\Templates\Title;

/**
 * Class description
 */
// class Test_Title {

// 	function __construct( Title $title ) {
// 		$this->title = $title;
// 	}
// }

// $test_title = $injector->make( 'ItalyStrap\Core\Test_Title' );
// $event_manager->remove_subscriber( $test_title->title );
// $event_manager->remove_subscriber( $registered_classes['title'] );
// var_dump( $test_title->title );
// var_dump( $event_manager );
// var_dump( $registered_classes['title'] === $test_title->title );
