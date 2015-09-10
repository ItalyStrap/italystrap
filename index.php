<?php
/*
 * Index file
 */
get_header(); ?>
<!-- Main Content -->
	<section id="index">
		<?php do_action( 'content_open' ); ?>
		<div class="container">
			<?php do_action( 'content_container_open' ); ?>
			<div class="row">
				<div class="col-md-8" itemscope itemtype="http://schema.org/CollectionPage">
					<?php
					do_action( 'content_col_open' );

					if ( have_posts() ) : while ( have_posts() ) : the_post();

						get_template_part( 'loops/content', get_post_type() );

					endwhile;

						bootstrap_pagination();

					else :

						get_template_part( 'loops/content', 'none');

					endif;
						wp_reset_query();
						wp_reset_postdata();


					do_action( 'content_col_closed' ); ?>
				</div><!-- / .col-md-8 -->
				<?php get_sidebar(); ?> 
			</div><!-- / .row -->
			<?php do_action( 'content_container_closed' ); ?>
		</div><!-- / .container -->
		<?php do_action( 'content_closed' ); ?>
	</section><!-- / #index -->

<?php get_footer(); ?>