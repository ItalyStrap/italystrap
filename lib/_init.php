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

use ItalyStrap\Core\Layout\Layout;
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

$event_manager->add_subscriber( $injector->make( '\ItalyStrap\Core\Asset\Asset_Factory' ) );
$event_manager->add_subscriber( $injector->make( '\ItalyStrap\Core\Tag_Cloud\Tag_Cloud' ) );

/**
 * WooCommerce
 */
$event_manager->add_subscriber( $injector->make( '\ItalyStrap\Core\WooCommerce\WooCommerce' ) );
$event_manager->add_subscriber( $injector->make( '\ItalyStrap\Core\WooCommerce\Form_Field' ) );

/**
 * Layout object
 *
 * @var Layout
 */
$site_layout = new Layout( (array) $theme_mods );
add_action( 'italystrap_theme_loaded', array( $site_layout, 'init' ) );

$event_manager->add_subscriber( $site_layout );

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

$registered_template_classes = array(
	'Navbar_Top'		=> '\ItalyStrap\Core\Templates\Navbar_Top',
	'Header_Image'		=> '\ItalyStrap\Core\Templates\Header_Image',
	'Nav_Menu'			=> '\ItalyStrap\Core\Templates\Nav_Menu',
	'Breadcrumbs'		=> '\ItalyStrap\Core\Templates\Breadcrumbs',
	'Archive_Headline'	=> '\ItalyStrap\Core\Templates\Archive_Headline',
	'Author_Info'		=> '\ItalyStrap\Core\Templates\Author_Info',
	'Loop'				=> '\ItalyStrap\Core\Templates\Loop',
	'Entry'				=> '\ItalyStrap\Core\Templates\Entry',
	'Title'				=> array(
		'\ItalyStrap\Core\Templates\Title',
		// 35,
	),
	'Meta'				=> '\ItalyStrap\Core\Templates\Meta',
	'Preview'			=> '\ItalyStrap\Core\Templates\Preview',
	'Featured_Image'	=> '\ItalyStrap\Core\Templates\Featured_Image',
	'Content'			=> '\ItalyStrap\Core\Templates\Content',
	'Link_Pages'		=> '\ItalyStrap\Core\Templates\Link_Pages',
	'Modified'			=> '\ItalyStrap\Core\Templates\Modified',
	'Edit_Post_Link'	=> '\ItalyStrap\Core\Templates\Edit_Post_Link',
	'Pager'				=> '\ItalyStrap\Core\Templates\Pager',
	'Pagination'		=> '\ItalyStrap\Core\Templates\Pagination',
	'None'				=> '\ItalyStrap\Core\Templates\None',
	'Sidebar'			=> '\ItalyStrap\Core\Templates\Sidebar',
	'Comments'			=> '\ItalyStrap\Core\Templates\Comments',
	'Password_Form'		=> '\ItalyStrap\Core\Templates\Password_Form',
	'Word_Count'		=> '\ItalyStrap\Core\Schema\Word_Count',
	'Time_Required'		=> '\ItalyStrap\Core\Schema\Time_Required',
	'Footer_Widget_Area'=> '\ItalyStrap\Core\Templates\Footer_Widget_Area',
	'Colophon'			=> '\ItalyStrap\Core\Templates\Colophon',
);

foreach ( $registered_template_classes as $class_name => $value ) {

	$class_name = strtolower( $class_name );
	$prefixed_classname = "italystrap_{$class_name}";

	if ( is_array( $value ) ) {
		add_filter( "italystrap_{$class_name}_priority", function ( $priority ) use ( $value ) {
			if ( ! isset( $value[1] ) ) {
				return $priority;
			}
			return $value[1];
		});

		$value = $value[0];
	}

	$$prefixed_classname = $injector->make( $value );
	$event_manager->add_subscriber( $$prefixed_classname );
}


$test_registered_template = array(

	'Title'	=> array(
		'\ItalyStrap\Core\Templates\Title'	=> array(
			'italystrap_entry_content'	=> array(
				'function_to_add'	=> 'render',
				'priority'			=> 10,
			),
		),
	),
);
// foreach ( $test_registered_template as $class_name => $value ) {

	// d( $value[1][0] );

	// $class_name = strtolower( $class_name );
	// $prefixed_classname = "italystrap_{$class_name}";



	// $$prefixed_classname = $injector->make( $value[0] );

	// add_action(
	// 	$value[1][0],
	// 	array( $$prefixed_classname, $value[1]['function_to_add'] ),
	// 	isset( $value[1]['priority'] ) ? $value[1]['priority'] : 10,
	// 	isset( $value[1]['accepted_args'] ) ? $value[1]['accepted_args'] : 1
	// );
	// $event_manager->add_subscriber( $$prefixed_classname );
// }

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
