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

get_header();
do_action( 'italystrap_before_main' );
?>
<!-- Main Content -->
	<main id="author-page">
		<div class="container">
			<div class="row">
				<?php do_action( 'italystrap_before_content' ); ?>
				<div <?php Core\get_attr( 'content', array( 'class' => 'col-md-8', 'itemscope' => true, 'itemtype' => 'https://schema.org/CollectionPage' ), true ); ?>>
					<?php
					do_action( 'italystrap_before_loop' );

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

							get_template_part( 'loops/content', get_post_type() );

						endwhile;
					else :

						get_template_part( 'loops/content', 'none' );

					endif;

					bootstrap_pagination();
					do_action( 'italystrap_after_loop' ); ?>
				</div><!-- / .col-md-8 -->
				<?php do_action( 'italystrap_after_content' ); ?>
				<?php get_sidebar(); ?> 
			</div><!-- / .row -->
		</div><!-- / .container -->
	</main><!-- / #author-p role="main"age -->
<?php
do_action( 'italystrap_after_main' );
get_footer();
