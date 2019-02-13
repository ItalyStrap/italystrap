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

$autoload_concrete = array_merge(
	$autoload_concrete,
	[
		'ItalyStrap\Asset\Asset_Factory',
		'ItalyStrap\Tag_Cloud\Tag_Cloud',
		'ItalyStrap\WooCommerce\WooCommerce',
		'ItalyStrap\WooCommerce\Form_Field',
		'ItalyStrap\Layout\Layout', // 'wp_loaded'
		'ItalyStrap\Migrations\Old_Hooks', // 'italystrap_plugin_app_loaded'
		// 'ItalyStrap\Controllers\Factory',

		'ItalyStrap\Controllers\Headers\Navbar_Top',
		'ItalyStrap\Controllers\Headers\Image',
		'ItalyStrap\Controllers\Headers\Nav_Menu',

		'ItalyStrap\Controllers\Misc\Archive_Headline',
		'ItalyStrap\Controllers\Misc\Author_Info',

		'ItalyStrap\Controllers\Posts\Loop',
		'ItalyStrap\Controllers\Posts\Post',
		'ItalyStrap\Controllers\Posts\None',
		'ItalyStrap\Controllers\Posts\None\Image',
		'ItalyStrap\Controllers\Posts\None\Title',
		'ItalyStrap\Controllers\Posts\None\Content',

		'ItalyStrap\Controllers\Posts\Parts\Breadcrumbs',
		'ItalyStrap\Controllers\Posts\Parts\Title',
		'ItalyStrap\Controllers\Posts\Parts\Meta',
		'ItalyStrap\Controllers\Posts\Parts\Preview',
		'ItalyStrap\Controllers\Posts\Parts\Featured_Image',
		'ItalyStrap\Controllers\Posts\Parts\Content',
		'ItalyStrap\Controllers\Posts\Parts\Link_Pages',
		'ItalyStrap\Controllers\Posts\Parts\Modified',
		'ItalyStrap\Controllers\Posts\Parts\Edit_Post_Link',
		'ItalyStrap\Controllers\Posts\Parts\Pager',
		'ItalyStrap\Controllers\Posts\Parts\Pagination',
		'ItalyStrap\Controllers\Posts\Parts\Password_Form',

		'ItalyStrap\Controllers\Sidebars\Sidebar',
		'ItalyStrap\Controllers\Comments\Comments',

		'ItalyStrap\Schema\Word_Count',
		'ItalyStrap\Schema\Time_Required',

		'ItalyStrap\Controllers\Footers\Widget_Area',
		'ItalyStrap\Controllers\Footers\Colophon',
	]
);

/* Questo filtro si trova nei file template per gestire commenti e breadcrumbs */
add_filter( 'italystrap_template_settings', function ( $array ) {
	return (array) get_post_meta( get_queried_object_id(), '_italystrap_template_settings', true );
} );

// $template_factory = new \ItalyStrap\Controllers\Factory( $theme_mods, $injector, $event_manager );
// $template_factory->register();
// add_action( 'wp_loaded', array( $template_factory, 'register' ) );

/**
 * Added for back-compatibility with old hooks
 *
 * @since 4.0.0
 *
 * @var Old_Hooks
 */
// $hooks_migrations = new \ItalyStrap\Migrations\Old_Hooks();
// $hooks_migrations = $injector->make( 'ItalyStrap\Migrations\Old_Hooks' );
// $hooks_migrations->convert();

// use ItalyStrap\Core\Templates\Title;

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
