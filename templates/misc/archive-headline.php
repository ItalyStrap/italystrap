<?php
/**
 * Template file for Archive headline
 * s
 *
 * @link www.italystrap.com
 * @since 1.0.0
 * @since WP 4.9.0 Added support for post type archives
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Misc;

?><header class="page-header"><?php 

	if ( 'search' === \CURRENT_TEMPLATE_SLUG ) {

		?><h1 itemprop="headline"><?php \printf( \esc_html__( 'Search result of: %s', 'italystrap' ), '<span>' . \get_search_query() . '</span>' ); ?></h1><?php
		return null;
	}

	\the_archive_title( '<h1 class="page-title" itemprop="name">', '</h1>' );
	\the_archive_description( '<div class="well taxonomy-description" itemprop="description">', '</div>' );
?></header>
