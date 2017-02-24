<?php
/**
 * The template for displaying search results pages
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
	<main id="search">
		<div class="container">
			<div class="row">
				<?php do_action( 'italystrap_before_content' ); ?>
				<div <?php Core\get_attr( 'content', array( 'class' => 'col-md-8', 'itemscope' => true, 'itemtype' => 'https://schema.org/SearchResultsPage' ), true ); ?>>
					<?php
					do_action( 'italystrap_before_loop' );

					if ( have_posts() ) :

						?>
						<header class="page-header">
							<h1 itemprop="headline"><?php printf( esc_html__( 'Search result of: %s', 'ItalyStrap' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
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
	</main>
<?php
do_action( 'italystrap_after_main' );
get_footer();
