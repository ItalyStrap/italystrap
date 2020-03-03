<?php
/**
 * This file init only front-end functionality.
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */
declare(strict_types=1);

namespace ItalyStrap;

use function add_action;
use function class_exists;
use function explode;
use function get_post_meta;
use function get_queried_object_id;
use function is_admin;
use function is_singular;
use function ItalyStrap\Factory\get_config;

if ( is_admin() ) {
	return [];
}

$subscribers = [
	Asset\Asset_Factory::class,
//	Components\Schema\Word_Count::class,
//	Components\Schema\Time_Required::class,
];

if ( class_exists( Migrations\Old_Hooks::class ) ) {
	$subscribers[] = Migrations\Old_Hooks::class;
}

/**
 * Load at 'wp' hook to make sure get_queried_object_id() returns the current page ID
 * 'wp_loaded' is too early
 *
 * @priority PHP_INT_MIN Make sure it will be loaded ASAP at 'wp' hook
 */
add_action( 'wp', function () {

	$config = get_config();
	$id = (int) get_queried_object_id();

	/**
	 * Front page ID get_option( 'page_on_front' ); PAGE_ON_FRONT
	 * Home page ID get_option( 'page_for_posts' ); PAGE_FOR_POSTS
	 * get_queried_object_id() before $post is sett
	 */
	$config->add( 'current_page_id', $id );

	/**
	 * If we are in singular page then load the template settings from post_meta
	 * If we are not in singular pages load the global post_content_template
	 * @TODO Forse qui è meglio settare i valori con l'hook "italystrap" nel file di template per avere la possibilità di poter cambiare il valore in esecuzione
	 */
	if ( is_singular() ) {
		$config->add(
			'post_content_template',
			(array) get_post_meta( $id, '_italystrap_template_settings', true )
		);
	} else {
		$config->add(
			'post_content_template',
			explode( ',', $config->get( 'post_content_template' ) )
		);
	}

	/**
	 * If in page settings are setted then override the global settings for the layout.
	 */
	if ( $page_layout = (string) get_post_meta( $id, '_italystrap_layout_settings', true ) ) {
		$config->add( 'site_layout', $page_layout );
	}

//	$config->add( 'site_layout',
//		(string) apply_filters( 'italystrap_get_layout_settings', $config->get( 'site_layout', 'content_sidebar' ) )
//	);
}, PHP_INT_MIN );

/**
 * @todo Questo va eseguito prima della registrazione delle sidebar se no non si può filtrare l'html dei widget
 */
add_action( 'after_setup_theme', '\ItalyStrap\HTML\filter_attr' );
//add_action( 'get_header', '\ItalyStrap\HTML\filter_attr' );

return $subscribers;
