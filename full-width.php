<?php
/**
 * Template Name: Full-width
 */
get_header(); ?>
    <!-- Main Content -->
    <section id="full-width">
    	<div class="container">
        	<div class="row">
                <div class="col-md-12">
                    <?php

                    if ( class_exists('ItalyStrapBreadcrumbs') ) {

                        $defaults = array(
                            'home'    =>  '<span class="glyphicon glyphicon-home" aria-hidden="true"></span>'
                        );

                        new ItalyStrapBreadcrumbs( $defaults );
                    
                    }

                    if (have_posts()) : while (have_posts()) : the_post();

                        get_template_part( 'loops/content', 'page' );

                        

                        endwhile;
                    else:

                        get_template_part( 'loops/content', 'none');

                    endif;
                    
					comments_template(); ?> 	
   
                </div><!-- / .col-md-8 -->
                
            </div><!-- / .row -->
		</div><!-- / .container -->
    </section><!-- / #full-width -->
   
<?php get_footer(); ?>