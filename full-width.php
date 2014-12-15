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
				<?php create_breadcrumbs(); ?>
				<?php get_template_part( 'loops/page', 'loop' ); ?>			
					<hr>
					<?php comments_template(); ?> 	
   
                </div><!-- / .col-md-8 -->
                
            </div><!-- / .row -->
		</div><!-- / .container -->
    </section><!-- / #full-width -->
   
<?php get_footer(); ?>