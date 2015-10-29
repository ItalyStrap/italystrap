<?php
/**
 * The template part for displaying single posts
 *
 * @package ItalyStrap
 * @since 1.0.0
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="page-header entry-header">
		<h1 class="entry-title">
			<a itemprop="url" href="<?php the_permalink(); ?>" title="<?php the_title_attribute() ?>" rel="bookmark">
				<span itemprop="headline">
					<?php the_title(); ?>
				</span>
			</a>
		</h1>
	</header>
	<footer class="entry-footer">
		<?php get_template_part( 'template/meta' ); ?>
	</footer>
	<?php if ( is_preview() ) : ?>
		<div class="alert alert-info">  
			<?php esc_attr_e( '<strong>Note:</strong> You are previewing this post. This post has not yet been published.', 'ItalyStrap' ); ?>  
		</div>  
	<?php endif; ?>
	<meta itemprop="image" content="<?php echo italystrap_thumb_url();?>"/>
	<section class="entry-content margin-bottom-25">
		<?php if ( has_post_thumbnail() ) { ?>
			<div class="margin-bottom-25 thumbnail">
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
		<div  itemprop="articleBody"><?php the_content(); ?></div>
		<span class="clearfix"></span>
		<?php wp_link_pages( array(
			'before' => '<p class="text-muted lead"><b>' . __( 'Pages:', 'ItalyStrap' ) . '</b>',
			'after' => '</p>',
			) );?>
		<p class="sr-only"><?php esc_attr_e( 'Last edit:', 'ItalyStrap' ); ?> <time datetime="<?php the_modified_time( 'Y-m-d' ) ?>" itemprop="dateModified"><?php the_modified_time( 'd F Y' ) ?></time></p>
		<span class="clearfix"></span>
			<?php edit_post_link( __( 'Edit', 'ItalyStrap' ), '<span class="btn btn-sm btn-primary margin-top-25">', '</span>' ); ?>
		<h3><?php esc_attr_e( 'Share this with your friends:', 'ItalyStrap' ); ?></h3>
		<textarea class="form-control" tabindex="4" rows="2"><?php the_permalink(); ?></textarea>
	</section><!-- /.entry-content -->
	<?php get_template_part( 'template/social-button' );?>
	<?php echo italystrap_ttr_wc();?>
	<span class="clearfix"></span>
	<?php get_template_part( 'template/content', 'author-info' );?>
	<meta itemprop="interactionCount" content="UserComments:<?php comments_number( 0, 1, '%' );?>" />
</article>
<ul class="pager">
	<li class="previous pager-prev"><?php previous_post_link( '%link', '<i class="glyphicon glyphicon-arrow-left"></i> %title' );?></li>
	<li class="next pager-next"><?php next_post_link( '%link', '%title <i class="glyphicon glyphicon-arrow-right"></i>' ) ?></li>
</ul>
<span class="clearfix"></span>
<hr>
