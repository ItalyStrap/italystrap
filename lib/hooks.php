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

use ItalyStrap\Core\Layout\Layout;
use ItalyStrap\Core\Template\Template;

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
 * Da leggere http://mikejolley.com/2013/12/15/deprecating-plugin-functions-hooks-woocommmerce/
 */

/**
 * Layout object
 *
 * @var Layout
 */
$layout = new Layout( (array) $theme_mods );
add_action( 'italystrap_after_content', array( $layout, 'get_sidebar' ) );
add_filter( 'italystrap_content_attr', array( $layout, 'set_content_class' ), 10, 3 );
add_filter( 'italystrap_sidebar_attr', array( $layout, 'set_sidebar_class' ), 10, 3 );

/**
 * Template object
 *
 * @var Template
 */
$template = new Template( (array) $theme_mods );

/**
 * Questo filtro si trova nei file template per gestire commenti e altro
 */
add_filter( 'italystrap_template_settings', array( $template, 'get_template_settings' ) );
add_action( 'italystrap_before_while', array( $template, 'archive_headline' ) );
add_action( 'italystrap_before_loop', array( $template, 'author_info' ) );
add_action( 'italystrap_after_loop', array( $template, 'pagination' ) );
add_action( 'italystrap_content_none', array( $template, 'content_none' ) );
add_action( 'italystrap_after_loop', array( $template, 'comments_template' ) );
