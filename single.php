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
				<?php create_breadcrumbs();
				get_template_part( 'loops/single', 'loop' ); ?>
					<hr>
					<?php comments_template(); ?> 	
   
                </div><!-- / .col-md-8 -->
				<?php get_sidebar(); ?> 
            </div><!-- / .row -->
		</div><!-- / .container -->
    </section><!-- / #single -->
   
<?php get_footer(); ?>