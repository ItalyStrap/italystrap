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

$events_manager->add_events( $injector->make( '\ItalyStrap\Core\Asset\Asset_Factory' ) );
$events_manager->add_events( $injector->make( '\ItalyStrap\Core\Tag_Cloud\Tag_Cloud' ) );

/**
 * WooCommerce
 */
$events_manager->add_events( $injector->make( '\ItalyStrap\Core\WooCommerce\WooCommerce' ) );
$events_manager->add_events( $injector->make( '\ItalyStrap\Core\WooCommerce\Form_Field' ) );

/**
 * Layout object
 *
 * @var Layout
 */
$site_layout = new Layout( (array) $theme_mods );
add_action( 'italystrap_theme_loaded', array( $site_layout, 'init' ) );

add_action( 'italystrap_after_content', array( $site_layout, 'get_sidebar' ) );

add_filter( 'italystrap_content_attr', array( $site_layout, 'set_content_class' ), 10, 3 );
add_filter( 'italystrap_sidebar_attr', array( $site_layout, 'set_sidebar_class' ), 10, 3 );
add_filter( 'italystrap_sidebar_secondary_attr', array( $site_layout, 'set_sidebar_secondary_class' ), 10, 3 );

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
	'\ItalyStrap\Core\Templates\Navbar_Top',
	'\ItalyStrap\Core\Templates\Header_Image',
	'\ItalyStrap\Core\Templates\Nav_Menu',
	'\ItalyStrap\Core\Templates\Breadcrumbs',
	'\ItalyStrap\Core\Templates\Archive_Headline',
	'\ItalyStrap\Core\Templates\Author_Info',
	'\ItalyStrap\Core\Templates\Loop',
	'\ItalyStrap\Core\Templates\Entry',
	'\ItalyStrap\Core\Templates\Title',
	'\ItalyStrap\Core\Templates\Meta',
	'\ItalyStrap\Core\Templates\Preview',
	'\ItalyStrap\Core\Templates\Featured_Image',
	'\ItalyStrap\Core\Templates\Content',
	'\ItalyStrap\Core\Templates\Link_Pages',
	'\ItalyStrap\Core\Templates\Modified',
	'\ItalyStrap\Core\Templates\Edit_Post_Link',
	'\ItalyStrap\Core\Templates\Pager',
	'\ItalyStrap\Core\Templates\Pagination',
	'\ItalyStrap\Core\Templates\None',
	'\ItalyStrap\Core\Templates\Comments',
	'\ItalyStrap\Core\Templates\Password_Form',
	'\ItalyStrap\Core\Schema\Word_Count',
	'\ItalyStrap\Core\Schema\Time_Required',
);

foreach ( $registered_template_classes as $value ) {
	$events_manager->add_events( $injector->make( $value ) );
}

add_action( 'italystrap_footer', array( $template_settings, 'do_footer' ) );
