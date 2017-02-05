<?php
/**
 * Template file for Archive headline
 * s
 *
 * @link www.italystrap.com
 * @since 1.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

?><header class="page-header"><?php 

	if ( 'search' === CURRENT_TEMPLATE_SLUG ) {

		?><h1 itemprop="headline"><?php printf( esc_html__( 'Search result of: %s', 'italystrap' ), '<span>' . get_search_query() . '</span>' ); ?></h1><?php
		return null;
	}

	the_archive_title( '<h1 class="page-title" itemprop="name">', '</h1>' );
	the_archive_description( '<div class="well taxonomy-description" itemprop="description">', '</div>' );

	/**
	 * Display or retrieve title for a Custom Post Type archive.
	 * This is optimized for archive.php and archive-{posttype}.php template files for displaying the title of the CPT.
	 */
	if ( is_post_type_archive() ) {

		$post_type_object = get_post_type_object( get_post_type() );

		if ( $post_type_object ) {

			?><div class="well" itemprop="description"><p><?php echo wp_kses_post( $post_type_object->description ); ?></p></div><?php
		}
	}
?></header>
