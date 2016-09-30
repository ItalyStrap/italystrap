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
add_action( 'italystrap_before_loop', __NAMESPACE__ . '\display_breadcrumbs' );

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
 * FOOTER
 */

/**
 * Footer open markup
 *
 * @param  string $value [description]
 * @return string        [description]
 */
function footer_open_markup( $value = '' ) {

	?><!-- Footer --><footer class="site-footer" itemscope itemtype="http://schema.org/WPFooter"><?php

}
add_action( 'italystrap_before_footer', __NAMESPACE__ . '\footer_open_markup', 9 );

/**
 * Do Footer
 *
 * @param  string $value [description]
 * @return string        [description]
 */
function do_footer( $value = '' ) {

	get_template_part( 'template/part', 'content-footer-widget-area' );
	get_template_part( 'template/part', 'content-footer-colophon' );

}
add_action( 'italystrap_footer', __NAMESPACE__ . '\do_footer' );

/**
 * Footer Close markup
 *
 * @param  string $value [description]
 * @return string        [description]
 */
function footer_close_markup( $value = '' ) {

	?></footer><!-- #footer --><?php

}
add_action( 'italystrap_after_footer', __NAMESPACE__ . '\footer_close_markup', 11 );

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
// function get_layout_settings() {

// 	/**
// 	 * Front page ID get_option( 'page_on_front' );
// 	 * Home page ID get_option( 'page_for_posts' );
// 	 */

// 	$id = '';

// 	if ( is_home() ) {
// 		$id = get_option( 'page_for_posts' );
// 	} else {
// 		$id = get_the_ID();
// 	}

// 	return get_post_meta( $id, '_italystrap_layout_settings', true );
// }
// add_filter( 'italystrap_template_settings', __NAMESPACE__ . '\get_layout_settings' );

$layout = new Layout( (array) $italystrap_theme_mods );

add_filter( 'italystrap_template_settings', array( $layout, 'get_template_settings' ) );

add_action( 'italystrap_before_while', array( $layout, 'archive_headline' ) );

add_action( 'italystrap_after_content', array( $layout, 'get_sidebar' ) );

add_action( 'italystrap_before_loop', array( $layout, 'author_info' ) );

add_action( 'italystrap_after_loop', array( $layout, 'pagination' ) );

add_action( 'italystrap_content_none', array( $layout, 'content_none' ) );

add_action( 'italystrap_after_loop', array( $layout, 'comments_template' ) );

$templates_page = array(
	// 'italystrap_{$context}_attr',
	// 'italystrap_index_attr',
	// 'italystrap_single_attr',
	// 'italystrap_page_attr',
	// 'italystrap_search_attr',
	// 'italystrap_full-width_attr',
	// 'italystrap_author_attr',
	// 'italystrap_archive_attr',
	// 'italystrap_404_attr',
	// 'italystrap_front-page_attr',
	// 'italystrap_home_attr',
	'italystrap_content_attr',
	);

foreach ( $templates_page as $key => $value ) {
	add_filter( $value, array( $layout, 'get_site_layout' ), 10, 3 );
}

/**
 * Set Current Template Constant
 * Call this constant from after the 'get_header' action.
 *
 * @param string $current_template Return the current temlate
 */
function set_current_template( $current_template ) {

	define( 'CURRENT_TEMPLATE', basename( $current_template ) );
	define( 'CURRENT_TEMPLATE_SLUG', str_replace( '.php', '', CURRENT_TEMPLATE ) );

	return $current_template;
}
add_filter( 'template_include', __NAMESPACE__ . '\set_current_template', 9999 );

/**
 * Get the current template file used.
 * Call this function after the 'get_header' action.
 *
 * @param  bool   $echo If true echo it.
 *
 * @return string       If $echo is false return the name of the template.
 */
// function get_current_template( $echo = false ) {

// 	if( ! defined( CURRENT_TEMPLATE ) && ! CURRENT_TEMPLATE ) {
// 		return null;
// 	}

// 	if ( ! $echo ) {
// 		return CURRENT_TEMPLATE;
// 	}

// 	echo CURRENT_TEMPLATE;
// }

// d( get_current_template() );
// d( CURRENT_TEMPLATE );

// add_action( 'get_header', function(){

// d( get_page_template() );
// d( basename( get_page_template() ) );
// d( get_current_template() );
// d( CURRENT_TEMPLATE );
// d( CURRENT_TEMPLATE_SLUG );
/**
 * Define ITALYSTRAP_THEME constant for internal use
 */
// define( 'CONTEXT', basename( get_page_template() ) );

// } );
