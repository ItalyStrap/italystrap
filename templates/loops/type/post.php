<?php
/**
 * The template part for displaying standard posts
 *
 * @package ItalyStrap
 * @since 1.0.0
 */

namespace ItalyStrap;

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h2 class="entry-title">
			<a itemprop="url" href="<?php the_permalink(); ?>" title="<?php the_title_attribute() ?>" rel="bookmark">
				<span itemprop="name">
					<?php the_title(); ?>
				</span>
			</a>
		</h2>
	</header>

	<?php get_template_part( 'templates/loops/type/parts/meta' ); ?>

	<?php get_template_part( 'templates/loops/type/parts/featured', 'image' ); ?>

	<div class="entry-content" itemprop="text"><?php the_excerpt(); ?></div><!-- /.entry-content -->

	<p class="sr-only"><?php esc_attr_e( 'Last edit:', 'ItalyStrap' ); ?> <time datetime="<?php the_modified_time( 'Y-m-d' ) ?>" itemprop="dateModified"><?php the_modified_time( 'd F Y' ) ?></time></p>
	<?php echo italystrap_ttr_wc(); // XSS ok. ?>
	<span class="clearfix"></span>
</article>
<hr>
