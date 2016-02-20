<?php namespace ItalyStrap\Core;
/**
 * ItalyStrap Hooks
 *
 * @since 4.0.0
 * @package ItalyStrap\Core
 */

/**
 * Theme init
 *
 * @see Class Init()
 */
add_action( 'after_setup_theme', array( $init, 'theme_setup' ) );

/**
 * General
 */
add_filter( 'widget_text', 'do_shortcode' ); // Allow shortcode in widget text.

/**
 * Header
 *
 * @see  add_top_menu() in gemeral-functions.php
 */
add_action( 'italystrap_content_header', __NAMESPACE__ . '\add_top_menu', 10 );
add_action( 'italystrap_content_header', __NAMESPACE__ . '\get_template_content_header', 20 );

/**
 * Content
 *
 * @see display_breadcrumbs()
 */
add_action( 'content_col_open', __NAMESPACE__ . '\display_breadcrumbs' );

/**
 * Footer
 */
