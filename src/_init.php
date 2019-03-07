<?php
/**
 * This file init only front-end functionality.
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap;

if ( is_admin() ) {
	return [];
}

$concretes = [
	'ItalyStrap\Asset\Asset_Factory',
	'ItalyStrap\Tag_Cloud\Tag_Cloud',
	'ItalyStrap\WooCommerce\WooCommerce',
	'ItalyStrap\WooCommerce\Form_Field',
	'ItalyStrap\Layout\Layout',

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
];

if ( defined( 'ITALYSTRAP_PLUGIN' ) ) {
	$concretes[] = 'ItalyStrap\Migrations\Old_Hooks';
}

/* Questo filtro si trova nei file template per gestire commenti e breadcrumbs */
add_filter( 'italystrap_template_settings', function ( $array ) {
	return (array) get_post_meta( get_queried_object_id(), '_italystrap_template_settings', true );
} );

return $concretes;
