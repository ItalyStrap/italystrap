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

use Auryn\InjectorException;
use ItalyStrap\Builders\ParseAttr;
use ItalyStrap\Config\ConfigFactory;
use function add_action;
use function array_replace_recursive;
use function class_exists;
use function explode;
use function get_post_meta;
use function get_queried_object_id;
use function is_admin;
use function is_singular;
use function ItalyStrap\Config\get_config_file_content;
use function ItalyStrap\Factory\get_config;
use function ItalyStrap\Factory\injector;

if ( is_admin() ) {
	return [];
}

$subscribers = [
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
	 * get_queried_object_id() before $post is set
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
			explode( ',',
				is_array( $config->get( 'post_content_template' ) )
				? $config->get( 'post_content_template' )[0]
				: $config->get( 'post_content_template' )
			)
		);
	}

	/**
	 * If in page settings are set then override the global settings for the layout.
	 */
	if ( $page_layout = (string) get_post_meta( $id, '_italystrap_layout_settings', true ) ) {
		$config->add( 'site_layout', $page_layout );
	}

	/**
	 * If in page settings are set then override the global settings for the layout.
	 */
	if ( $container_width = (string) get_post_meta( $id, '_italystrap_width_settings', true ) ) {
		$config->add( 'container_width', $container_width );
	}

//	$config->add( 'site_layout',
//		(string) apply_filters( 'italystrap_get_layout_settings', $config->get( 'site_layout', 'content_sidebar' ) )
//	);
}, PHP_INT_MIN );

/**
 * Questo va eseguito prima della registrazione delle sidebar
 * se no non si può filtrare l'html dei widget
 *
 * @see \ItalyStrap\Builders\ParseAttr
 */
//add_action('after_setup_theme', function (){
add_action('widgets_init', function (){

//	if ( \did_action('widgets_init') ) {
//		throw new \RuntimeException('This ' . __FUNCTION__ . ' must run before register widget');
//	}

	try {
		$schema = get_config_file_content( 'schema' );
		$html_attrs = get_config_file_content( 'html_attrs' );

		$config = ConfigFactory::make( (array) array_replace_recursive( $schema, $html_attrs ) );

		$parser =  injector()->make(
			ParseAttr::class
			,
			[ ':config' => $config ]
		);

		$parser->apply();

	} catch ( InjectorException $exception ) {
		echo $exception->getMessage();
	}

}, -10);

return $subscribers;
