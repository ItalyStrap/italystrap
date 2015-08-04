<?php
/*
 * Index file
 */
get_header(); ?>
    <!-- Main Content -->
	<section id="index">
        <div class="container">
            <div class="row">
				<div class="col-md-8" itemscope itemtype="http://schema.org/CollectionPage">
				<?php

                    if ( class_exists('ItalyStrapBreadcrumbs') ) {

                        $defaults = array(
                            'home'    =>  '<span class="glyphicon glyphicon-home" aria-hidden="true"></span>'
                        );

                        new ItalyStrapBreadcrumbs( $defaults );
                    
                    }

					if ( have_posts() ) : while ( have_posts() ) : the_post();

						get_template_part( 'loops/content', 'archive' );

					endwhile;

						bootstrap_pagination();

					else :

						get_template_part( 'loops/content', 'none');

					endif;
						wp_reset_query();
						wp_reset_postdata();
?>


				</div><!-- / .col-md-8 -->
				<?php get_sidebar(); ?> 
			</div><!-- / .row -->
		</div><!-- / .container -->
	</section><!-- / #index -->

<?php get_footer(); ?>