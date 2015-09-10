<?php
/**
 * The author template file.
 */
get_header(); ?>
<!-- Main Content -->
	<section id="author-page">
		<?php do_action( 'content_open' ); ?>
		<div class="container">
			<?php do_action( 'content_container_open' ); ?>
			<div class="row">
				<div class="col-md-8" itemscope itemtype="http://schema.org/CollectionPage">
					<?php do_action( 'content_col_open' );
					get_template_part( 'template/content', 'author-info' ); ?>
					<header class="page-header">
						<h2 itemprop="name"><?php the_archive_title(); ?></h2>
						<?php the_archive_description(); ?>
					</header>
					<?php
					query_posts( 'cat=-&paged=' . $paged );
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
	</section><!-- / #author-page -->
<?php get_footer(); ?>