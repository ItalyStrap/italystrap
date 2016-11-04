<?php
/**
 * The template part for displaying the standard loop
 *
 * @package ItalyStrap
 * @since 4.0.0
 */

namespace ItalyStrap;

do_action( 'italystrap_before_loop' );

if ( have_posts() ) :

	do_action( 'italystrap_before_while' );

	while ( have_posts() ) :

		the_post();

		$file_type = get_post_type();

		if ( 'single' === CURRENT_TEMPLATE_SLUG ) {
			$file_type = 'single';
		}

		if ( 'search' === CURRENT_TEMPLATE_SLUG ) {
			$file_type = 'post';
		}

		get_template_part( 'templates/loops/'. $file_type );

	endwhile;

	do_action( 'italystrap_after_while' );

else :

	do_action( 'italystrap_content_none' );

endif;

do_action( 'italystrap_after_loop' );
