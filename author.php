<?php
/**
 * The template for displaying author page
 *
 * Used to display author-type pages if nothing more specific matches a query.
 * For example, puts together authors pages if no author-{nicename}.php or author-{id}.php files exists.
 *
 * If you'd like to further customize these author views, you may create a
 * new template file for each one. For example, author-{nicename}.php or author-{id}.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ItalyStrap
 * @since 1.0.0
 */

namespace ItalyStrap;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

get_header(); ?>
<!-- Main Content -->
	<main id="author-page" role="main">
		<?php do_action( 'content_open' ); ?>
		<div class="container">
			<?php do_action( 'content_container_open' ); ?>
			<div class="row">
				<div class="col-md-8" itemscope itemtype="http://schema.org/CollectionPage">
					<?php do_action( 'content_col_open' );

					get_template_part( 'template/content', 'author-info' );

					if ( have_posts() ) :

						?>
						<header class="page-header">
							<?php
							the_archive_title( '<h1 class="page-title" itemprop="name">', '</h1>' );
							the_archive_description( '<div class="well taxonomy-description" role="alert" itemprop="description"><p>', '</p></div>' );
							?>
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
	</main><!-- / #author-p role="main"age -->
<?php get_footer();
