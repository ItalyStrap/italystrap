<?php
/**
 * The template part for displaying the standard loop
 *
 * @package ItalyStrap
 * @since 4.0.0
 */

namespace ItalyStrap;

if ( have_posts() ) :

	do_action( 'italystrap_before_while' );

	while ( have_posts() ) :

		the_post();

		do_action( 'italystrap_before_entry' );

		do_action( 'italystrap_entry' );

		do_action( 'italystrap_after_entry' );

	endwhile;

	do_action( 'italystrap_after_while' );

else :

	do_action( 'italystrap_content_none' );

endif;
