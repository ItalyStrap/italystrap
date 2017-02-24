<?php
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

namespace ItalyStrap;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

get_header();
do_action( 'italystrap_before_main' );
?>
<!-- Main Content -->
	<main id="archive">
		<div class="container">
			<div class="row">
				<?php do_action( 'italystrap_before_content' ); ?>
				<div <?php Core\get_attr( 'content', array( 'class' => 'col-md-8', 'itemscope' => true, 'itemtype' => 'https://schema.org/CollectionPage' ), true ); ?>>
					<?php
					do_action( 'italystrap_before_loop' );



					if ( have_posts() ) :

						?>
						<header class="page-header">
							<?php
							the_archive_title( '<h1 class="page-title" itemprop="name">', '</h1>' );
							the_archive_description( '<div class="well taxonomy-description" role="alert" itemprop="description">', '</div>' );

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
					do_action( 'italystrap_after_loop' ); ?>
				</div><!-- / .col-md-8 -->
				<?php do_action( 'italystrap_after_content' ); ?>
				<?php get_sidebar(); ?> 
			</div><!-- / .row -->
		</div><!-- / .container -->
	</main><!-- / #archive -->
	
<?php
do_action( 'italystrap_after_main' );
get_footer();
