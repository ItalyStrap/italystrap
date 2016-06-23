<?php
/**
 * The template part for displaying the standard loop
 *
 * @package ItalyStrap
 * @since 4.0.0
 */

namespace ItalyStrap;
// d( $layout_settings );
if ( have_posts() ) :

	while ( have_posts() ) :

		the_post();

		get_template_part( 'loops/content', get_post_type() );

	endwhile;

	bootstrap_pagination();

else :

	get_template_part( 'loops/content', 'none' );

endif;
