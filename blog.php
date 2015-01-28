<?php
/*
 * Template Name: blog
 */
get_header(); ?>
    <!-- Main Content -->
	<section id="blog">
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

					$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
					$blog = new WP_Query(
										array( 
												'post_type'		=>	'post',
												'pagination'        => true,
												'paged'             => $paged,
												// 'posts_per_page' 	=> $posts_per_page,
												));
					if ( $blog->have_posts() ) : while ( $blog->have_posts() ) : $blog->the_post();

						get_template_part( 'loops/content', 'archive' );

					endwhile;

						bootstrap_pagination( $blog );

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
	</section><!-- / #blog -->

<?php get_footer(); ?>