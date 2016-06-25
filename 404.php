<?php
/**
 * The template for displaying 404 pages (not found)
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
	<main id="error404" role="main">
		<?php do_action( 'content_open' ); ?>
		<div class="container">
			<?php do_action( 'content_container_open' ); ?>
			<div class="row">
				<div class="col-md-8">
					<?php
					do_action( 'content_col_open' );
					do_action( 'italystrap_before_loop' );

					get_template_part( 'loops/content', 'none' );
					get_template_part( 'template/sitemap_html' );












					do_action( 'content_col_closed' ); ?>
				</div><!-- / .col-md-8 -->
				<?php get_sidebar(); ?> 
			</div><!-- / .row -->
			<?php do_action( 'content_container_closed' ); ?>
		</div><!-- / .container -->
		<?php do_action( 'content_closed' ); ?>
	</main><!-- / #error404 -->

<?php
do_action( 'italystrap_after_main' );
get_footer();
