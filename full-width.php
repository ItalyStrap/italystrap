<?php
/**
 * Template Name: Full-width
 *
 * The template for displaying pages in full with style
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ItalyStrap
 * @since 1.0.0
 */

namespace ItalyStrap;

/**
 * Change the thumbnail size for the old template full-width.php
 *
 * @param  string $size    The thumbnail size.
 * @param  string $context The context.
 * @return string          The thumbnail size.
 */
//function post_thumbnail_size( $size, $context ) {
//
//	if ( is_page_template( 'full-width.php' ) ) {
//		return 'full-width';
//	}
//
//	return $size;
//
//}
//add_action( 'italystrap_post_thumbnail_size', __NAMESPACE__ . '\post_thumbnail_size', 10, 2 );

italystrap();
