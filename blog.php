<?php
/*
 * Template Name: blog
 */
get_header();?>
    <!-- Main Content -->
	<section id="blog">
        <div class="container">
            <div class="row">
				<div class="col-md-8" itemscope itemtype="http://schema.org/CollectionPage">
				<?php create_breadcrumbs();
				get_template_part( 'loops/blog', 'loop' ); ?>



				</div><!-- / .col-md-8 -->
				<?php get_sidebar(); ?> 
			</div><!-- / .row -->
		</div><!-- / .container -->
	</section><!-- / #blog -->

<?php get_footer(); ?>