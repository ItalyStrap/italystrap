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

get_header();
do_action( 'italystrap_before_main' );
?>
<!-- Main Content -->
	<main id="full-width">
		<div class="container">
			<div class="row">
				<?php do_action( 'italystrap_before_content' ); ?>
				<div <?php Core\get_attr( 'content', array( 'class' => 'col-md-12', 'itemscope' => true, 'itemtype' => 'https://schema.org/Article' ), true ); ?>>
					<?php
					do_action( 'italystrap_before_loop' );

					if ( have_posts() ) :

						while ( have_posts() ) :

							the_post();

							get_template_part( 'loops/content', get_post_type() );



						endwhile;
					else :

						get_template_part( 'loops/content', 'none' );

					endif;

					comments_template();
					do_action( 'italystrap_after_loop' ); ?>
				</div><!-- / .col-md-8 -->
				<?php do_action( 'italystrap_after_content' ); ?>
			</div><!-- / .row -->
		</div><!-- / .container -->
	</main><!-- / #full-width -->
   
<?php
do_action( 'italystrap_after_main' );
get_footer();
