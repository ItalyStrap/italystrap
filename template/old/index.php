<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
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
	<main id="index">
		<div class="container">
			<div class="row">
				<?php do_action( 'italystrap_before_content' ); ?>
				<div <?php Core\get_attr( 'content', array( 'class' => 'col-md-8', 'itemscope' => true, 'itemtype' => 'https://schema.org/CollectionPage' ), true ); ?>>
					<?php
					// do_action( 'content_col_open' );

					do_action( 'italystrap_before_loop' );
					do_action( 'italystrap_loop' );

					// get_template_part( 'loops/loop' );
					// require locate_template( '/loops/loop.php' );

					// if ( have_posts() ) :

					// 	while ( have_posts() ) :

					// 		the_post();

					// 		get_template_part( 'loops/content', get_post_type() );

					// 	endwhile;

					// 	bootstrap_pagination();

					// else :

					// 	get_template_part( 'loops/content', 'none' );

					// endif;

					do_action( 'italystrap_after_loop' ); ?>
				</div><!-- / .col-md-8 -->
				<?php do_action( 'italystrap_after_content' ); ?>
				<?php get_sidebar(); ?>
			</div><!-- / .row -->
		</div><!-- / .container -->
	</main><!-- / #index -->

<?php
do_action( 'italystrap_after_main' );
get_footer();
