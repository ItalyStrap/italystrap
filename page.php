<?php
/**
 * The page template file.
 */
get_header(); ?>
<!-- Main Content -->
	<section id="page">
		<?php do_action( 'content_open' ); ?>
		<div class="container">
			<?php do_action( 'content_container_open' ); ?>
			<div class="row">
				<div class="col-md-8">
					<?php
					do_action( 'content_col_open' );

					if ( have_posts() ) : while ( have_posts() ) : the_post();

						get_template_part( 'loops/content', 'page' );



						endwhile;
					else:

						get_template_part( 'loops/content', 'none');

					endif;

					comments_template();
					do_action( 'content_col_closed' ); ?>
				</div><!-- / .col-md-8 -->
				<?php get_sidebar(); ?> 
			</div><!-- / .row -->
			<?php do_action( 'content_container_closed' ); ?>
		</div><!-- / .container -->
		<?php do_action( 'content_closed' ); ?>
	</section><!-- / #page -->

<?php get_footer(); ?>