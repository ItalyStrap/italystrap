<?php
/**
 * The template for displaying pages
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

$layout_settings = (array) apply_filters( 'italystrap_layout_settings', array() );
get_header(); ?>
<!-- Main Content -->
	<main id="page" role="main">
		<?php do_action( 'content_open' ); ?>
		<div class="container">
			<?php do_action( 'content_container_open' ); ?>
			<div class="row">
				<div <?php Core\content_class( 'col-md-8' ) ?> itemscope itemtype="http://schema.org/Article">
					<?php
					do_action( 'content_col_open' );

					if ( have_posts() ) :

						while ( have_posts() ) :

							the_post();

							get_template_part( 'loops/content', get_post_type() );



						endwhile;
					else :

						get_template_part( 'loops/content', 'none' );

					endif;

					comments_template();
					do_action( 'content_col_closed' ); ?>
				</div><!-- / .col-md-8 -->
				<?php
				if ( ! in_array( 'hide_sidebar', $layout_settings, true ) ) { 
					get_sidebar();
				}
				?>
			</div><!-- / .row -->
			<?php do_action( 'content_container_closed' ); ?>
		</div><!-- / .container -->
		<?php do_action( 'content_closed' ); ?>
	</main><!-- / #page -->

<?php get_footer();
