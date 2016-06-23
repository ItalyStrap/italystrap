<?php
/**
 * ItalyStrap Hooks
 *
 * @since 4.0.0
 * @package ItalyStrap\Core
 */

namespace ItalyStrap\Core;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

/**
 * Theme init
 *
 * @see Class Init()
 */
add_action( 'after_setup_theme', array( $init, 'theme_setup' ) );

/**
 * Header
 *
 * @see  add_top_menu() in general-functions.php
 * @see  get_template_content_header() in general-functions.php
 * @see  Class Navbar in class-navbar.php
 */
add_action( 'italystrap_content_header', __NAMESPACE__ . '\add_top_menu', 10 );
add_action( 'italystrap_content_header', __NAMESPACE__ . '\get_template_content_header', 20 );
add_action( 'italystrap_content_header', array( $navbar, 'output' ), 30 );

/**
 * Content
 *
 * @see display_breadcrumbs()
 */
add_action( 'content_col_open', __NAMESPACE__ . '\display_breadcrumbs' );

/**
 * Loop
 */

/**
 * Function description
 *
 * @param  string $value [description]
 * @return string        [description]
 */
function standard_loop( $context = '' ) {

	return require locate_template( '/loops/loop.php' );

}
add_action( 'italystrap_loop', __NAMESPACE__ . '\standard_loop' );

/**
 * Function description
 *
 * @param  string $value [description]
 * @return string        [description]
 */
function post_thumbnail_size( $size, $context ) {

	if ( is_page_template( 'full-width.php' ) ) {
		return 'full-width';
	}

	return $size;

}
add_action( 'italystrap_post_thumbnail_size', __NAMESPACE__ . '\post_thumbnail_size', 10, 2 );

/**
 * Function description
 *
 * @param  string $value [description]
 * @return string        [description]
 */
// function begin_fetch_post_thumbnail_html( $post_id, $post_thumbnail_id, $size ) {

// 	d( $post_id, $post_thumbnail_id, $size );

// }
// add_action( 'begin_fetch_post_thumbnail_html', __NAMESPACE__ . '\begin_fetch_post_thumbnail_html' );

/**
 * Da leggere http://mikejolley.com/2013/12/15/deprecating-plugin-functions-hooks-woocommmerce/
 */
function get_layout_settings() {

	/**
	 * Front page ID get_option( 'page_on_front' );
	 * Home page ID get_option( 'page_for_posts' );
	 */

	$id = '';

	if ( is_home() ) {
		$id = get_option( 'page_for_posts' );
	} else {
		$id = get_the_ID();
	}

	return get_post_meta( $id, '_italystrap_layout_settings', true );
}
add_filter( 'italystrap_layout_settings', __NAMESPACE__ . '\get_layout_settings' );
