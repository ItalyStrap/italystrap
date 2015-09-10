<?php
/**
 * The 404 template file.
 */
get_header(); ?>
<!-- Main Content -->
	<section id="error404">
		<?php do_action( 'content_open' ); ?>
		<div class="container">
			<?php do_action( 'content_container_open' ); ?>
			<div class="row">
				<div class="col-md-8">
					<?php
					do_action( 'content_col_open' );

					get_template_part( 'loops/content', 'none');
					get_template_part( 'template/sitemap_html');












					do_action( 'content_col_closed' ); ?>
				</div><!-- / .col-md-8 -->
				<?php get_sidebar(); ?> 
			</div><!-- / .row -->
			<?php do_action( 'content_container_closed' ); ?>
		</div><!-- / .container -->
		<?php do_action( 'content_closed' ); ?>
	</section><!-- / #error404 -->

<?php get_footer(); ?>