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
	\ItalyStrap\Asset\Asset_Factory::class,
	\ItalyStrap\User\Contact_Methods::class,

//	'\ItalyStrap\Schema\Word_Count',
//	'\ItalyStrap\Schema\Time_Required',

	'\ItalyStrap\Controllers\Headers\Navbar_Top',
	'\ItalyStrap\Controllers\Headers\Image',
	'\ItalyStrap\Controllers\Headers\Nav_Menu',

	'\ItalyStrap\Controllers\Misc\Archive_Headline',
	'\ItalyStrap\Controllers\Misc\Author_Info',

//	'\ItalyStrap\Controllers\Posts\Post',
//	'\ItalyStrap\Controllers\Posts\None',

//	'\ItalyStrap\Controllers\Posts\None\Image',
//	'\ItalyStrap\Controllers\Posts\None\Title',
//	'\ItalyStrap\Controllers\Posts\None\Content',

//	'\ItalyStrap\Controllers\Posts\Parts\Breadcrumbs',
//	'\ItalyStrap\Controllers\Posts\Parts\Title',
//	'\ItalyStrap\Controllers\Posts\Parts\Meta',
//	'\ItalyStrap\Controllers\Posts\Parts\Preview',
//	'\ItalyStrap\Controllers\Posts\Parts\Featured_Image',
//	'\ItalyStrap\Controllers\Posts\Parts\Content',
//	'\ItalyStrap\Controllers\Posts\Parts\Link_Pages',
//	'\ItalyStrap\Controllers\Posts\Parts\Modified',
//	'\ItalyStrap\Controllers\Posts\Parts\Edit_Post_Link',
//	'\ItalyStrap\Controllers\Posts\Parts\Pager',
//	'\ItalyStrap\Controllers\Posts\Parts\Pagination',
	'\ItalyStrap\Controllers\Posts\Parts\Password_Form', // Da errori se usato in structure

	'\ItalyStrap\Controllers\Sidebars\Sidebar',
	'\ItalyStrap\Controllers\Comments\Comments',

	'\ItalyStrap\Controllers\Footers\Widget_Area',
	'\ItalyStrap\Controllers\Footers\Colophon',
];

if ( defined( 'ITALYSTRAP_PLUGIN' ) ) {
	$concretes[] = 'ItalyStrap\Migrations\Old_Hooks';
}

/**
 * Load at 'wp' hook to make sure get_queried_object_id() returns the current page ID
 * 'wp_loaded' is too early
 *
 * @priority -1 Make sure it will be loaded ASAP at 'wp' hook
 */
add_action( 'wp', function (){

	$config = \ItalyStrap\Factory\get_config();
	$id = (int) get_queried_object_id();

	/**
	 * Front page ID get_option( 'page_on_front' ); PAGE_ON_FRONT
	 * Home page ID get_option( 'page_for_posts' ); PAGE_FOR_POSTS
	 * get_queried_object_id() before $post is sett
	 */
	$config->push( 'current_page_id', $id );

	/**
	 * If we are in singular page then load the template settings from post_meta
	 * If we are not in singular pages load the global post_content_template
	 *
	 */
	if ( is_singular() ) {
		$config->push( 'post_content_template',
			(array) get_post_meta( $id, '_italystrap_template_settings', true )
		);
	} else {
		$config->push(
			'post_content_template',
			explode( ',', $config->get( 'post_content_template' ) )
		);
	}

	/**
	 * If in page settings are setted then override the global settings for the layout.
	 */
	if ( $page_layout = (string) get_post_meta( $id, '_italystrap_layout_settings', true ) ) {
		$config->push( 'site_layout', $page_layout );
	}

//	$config->push( 'site_layout',
//		(string) apply_filters( 'italystrap_get_layout_settings', $config->get( 'site_layout', 'content_sidebar' ) )
//	);

	/**
	 * For now load here
	 */
//	\ItalyStrap\HTML\filter_attr();

}, PHP_INT_MIN );

add_action( 'get_header', '\ItalyStrap\HTML\filter_attr' );

return $concretes;
