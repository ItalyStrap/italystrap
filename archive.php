<?php namespace ItalyStrap;
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ItalyStrap
 * @since 1.0.0
 */

get_header(); ?>
<!-- Main Content -->
	<main id="archive" role="main">
		<?php do_action( 'content_open' ); ?>
		<div class="container">
			<?php do_action( 'content_container_open' ); ?>
			<div class="row">
				<div class="col-md-8" itemscope itemtype="http://schema.org/CollectionPage">
					<?php do_action( 'content_col_open' );



					if ( have_posts() ) :

						?>
						<header class="page-header">
							<?php
							the_archive_title( '<h1 class="page-title" itemprop="name">', '</h1>' );
							the_archive_description( '<div class="well taxonomy-description" role="alert" itemprop="description"><p>', '</p></div>' );

							/**
							 * Display or retrieve title for a Custom Post Type archive.
							 * This is optimized for archive.php and archive-{posttype}.php template files for displaying the title of the CPT.
							 */
							if ( is_post_type_archive() ) {

								$cpt_description = get_post_type_object( get_post_type() );

								if ( $cpt_description ) { ?>

								<div class="well" role="alert" itemprop="description"><p>
									<?php echo esc_attr( $cpt_description->description ); ?>
								</p></div>

								<?php }
							} ?>
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
	</main><!-- / #archive -->
	
<?php get_footer();
