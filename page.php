<?php
/**
 * The page template file.
 */
get_header(); ?>
    <!-- Main Content -->
    <section id="page">
    	<div class="container">
        	<div class="row">
                <div class="col-md-8">
				<?php create_breadcrumbs(); ?>
				<?php get_template_part( 'loops/page', 'loop' ); ?>			
					<hr>
					<?php comments_template(); ?> 	
   
                </div><!-- / .col-md-8 -->
				<?php get_sidebar(); ?> 
            </div><!-- / .row -->
		</div><!-- / .container -->
    </section><!-- / #page -->
   
<?php get_footer(); ?>