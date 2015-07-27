<?php
/**
 * Template Name: Sitemap HTML
 */
get_header(); ?>
    <!-- Main Content -->
    <section id="sitemap-html">
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
                    do_action( 'before_loop' );
                    get_template_part( 'loops/content', 'sitemaps-html' );

					?>
                </div>	
				<?php get_sidebar(); ?> 
            </div>
		</div>
    </section><!-- #content -->
   
<?php get_footer(); ?>