<?php
/**
 * The template for displaying search results pages
 *
 * @package ItalyStrap
 * @since 1.0.0
 */

get_header(); ?>
<!-- Main Content -->
	<main id="search" role="main">
		<?php do_action( 'content_open' ); ?>
		<div class="container">
			<?php do_action( 'content_container_open' ); ?>
			<div class="row">
				<div class="col-md-8" itemscope itemtype="http://schema.org/SearchResultsPage">
					<?php do_action( 'content_col_open' );

					if ( have_posts() ) :

						?>
						<header class="page-header">
							<h1 itemprop="headline"><?php printf( esc_html__( 'Search result of: %s', 'ItalyStrap' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
						</header>
						<?php

						while ( have_posts() ) :

							the_post();

							get_template_part( 'loops/content', 'post' );

						endwhile;
					else :

						get_template_part( 'loops/content', 'none' );

					endif;

					bootstrap_pagination();
					do_action( 'content_col_closed' ); ?>
				</div><!-- / .col-md-8 -->
				<?php get_sidebar(); ?> 
			</div><!-- / .row -->
			<?php do_action( 'content_container_closed' ); ?>
		</div><!-- / .container -->
		<?php do_action( 'content_closed' ); ?>
	</main>
<?php get_footer();
