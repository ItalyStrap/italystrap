<?php
/**
 * The search template file.
 */
get_header(); ?>
<!-- Main Content -->
	<section id="search">
		<?php do_action( 'content_open' ); ?>
		<div class="container">
			<?php do_action( 'content_container_open' ); ?>
			<div class="row">
				<div class="col-md-8" itemscope itemtype="http://schema.org/SearchResultsPage">
					<?php do_action( 'content_col_open' ); ?>
					<header class="page-header">
						<h1 itemprop="headline"><?php printf( __( 'Search result of: %s', 'ItalyStrap' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
					</header>
					<?php
					if ( have_posts() ) : while ( have_posts() ) : the_post();

						get_template_part( 'loops/content', 'post' );

					endwhile;
					else : 

						get_template_part( 'loops/content', 'none');

					endif;
					wp_reset_query();
					bootstrap_pagination();
					do_action( 'content_col_closed' ); ?>
				</div><!-- / .col-md-8 -->
				<?php get_sidebar(); ?> 
			</div><!-- / .row -->
			<?php do_action( 'content_container_closed' ); ?>
		</div><!-- / .container -->
		<?php do_action( 'content_closed' ); ?>
	</section>
<?php get_footer(); ?>