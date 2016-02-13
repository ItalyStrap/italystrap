<?php namespace ItalyStrap;
/**
 * The template part for displaying standard posts
 *
 * @package ItalyStrap
 * @since 1.0.0
 */

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
	<footer class="entry-footer">
		<?php get_template_part( 'template/meta' ); ?>
	</footer>
	<meta itemprop="image" content="<?php echo italystrap_thumb_url();?>"/>
	<section class="entry-content">
		<?php if ( has_post_thumbnail() ) { ?>
			<div class="thumbnail">
				<figure>
			  		<?php
			  		the_post_thumbnail(
			  			'article-thumb',
			  			array(
			  				'class' => 'center-block img-responsive',
			  				'alt'   => trim( strip_tags( get_post_meta( get_post_thumbnail_id( $post->ID ), '_wp_attachment_image_alt', true ) ) ),
			  				) );
			  		?>
				</figure>
			</div>
		<?php } ?>
		<div  itemprop="text"><?php the_excerpt(); ?></div>
		<p class="sr-only"><?php esc_attr_e( 'Last edit:', 'ItalyStrap' ); ?> <time datetime="<?php the_modified_time( 'Y-m-d' ) ?>" itemprop="dateModified"><?php the_modified_time( 'd F Y' ) ?></time></p>
		<span class="clearfix"></span>
	</section><!-- /.entry-content -->
	<?php echo italystrap_ttr_wc();?>
	<span class="clearfix"></span>
</article>
<hr>
