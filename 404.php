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
	<main id="error404">
		<div class="container">
			<div class="row">
				<?php do_action( 'italystrap_before_content' ); ?>
				<div <?php Core\get_attr( 'content', array( 'class' => 'col-md-8' ), true ); ?>>
					<?php
					do_action( 'italystrap_before_loop' );

					get_template_part( 'templates/loops/none' );

					do_action( 'italystrap_after_loop' ); ?>
				</div><!-- / .col-md-8 -->
				<?php do_action( 'italystrap_after_content' ); ?>
				<?php //get_sidebar(); ?> 
			</div><!-- / .row -->
		</div><!-- / .container -->
	</main><!-- / #error404 -->

<?php
do_action( 'italystrap_after_main' );
get_footer();
