<?php
/**
 * The single template file.
 */
get_header(); ?> 
    <!-- Main Content -->
    <section id="single">
    	<div class="container">
        	<div class="row">
                <div class="col-md-8">
    				<?php

                    if ( class_exists('ItalyStrapBreadcrumbs') ) {

                        $defaults = array(
                            'home'    =>  '<span class="glyphicon glyphicon-home" aria-hidden="true"></span>'
                        );

                        new ItalyStrapBreadcrumbs( $defaults );

                    }
                    
                    if (have_posts()) : while (have_posts()) : the_post();

                        get_template_part( 'loops/content', 'single' );

                        show_related_posts();

                        endwhile;
                    else:

                        get_template_part( 'loops/content', 'none');

                    endif;
                    ?>
    				<hr>
					<?php comments_template(); ?> 	
   
                </div><!-- / .col-md-8 -->
				<?php get_sidebar(); ?> 
            </div><!-- / .row -->
		</div><!-- / .container -->
    </section><!-- / #single -->
   
<?php get_footer(); ?>