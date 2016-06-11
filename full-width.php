<?php
/**
 * Template Name: Full-width
 *
 * The template for displaying pages in full with style
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
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
	<main id="full-width" role="main">
		<?php do_action( 'content_open' ); ?>
		<div class="container">
			<?php do_action( 'content_container_open' ); ?>
			<div class="row">
				<div class="col-md-12" itemscope itemtype="http://schema.org/Article">
					<?php
					do_action( 'content_col_open' );

					if ( have_posts() ) :

						while ( have_posts() ) :

							the_post();

							get_template_part( 'loops/content', 'page' );



						endwhile;
					else :

						get_template_part( 'loops/content', 'none' );

					endif;

					comments_template();
					do_action( 'content_col_closed' ); ?>
				</div><!-- / .col-md-8 -->

			</div><!-- / .row -->
			<?php do_action( 'content_container_closed' ); ?>
		</div><!-- / .container -->
		<?php do_action( 'content_closed' ); ?>
	</main><!-- / #full-width -->
   
<?php get_footer();
