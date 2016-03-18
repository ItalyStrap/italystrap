<?php namespace ItalyStrap;
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
	<section class="entry-content">
		<?php if ( has_post_thumbnail() ) { ?>
			<figure class="<?php echo esc_attr( apply_filters( 'italystrap-figure-thumb-class', 'thumbnail' ) ); ?>">
		  		<?php
				the_post_thumbnail(
					'article-thumb',
					array(
						'class' => 'center-block img-responsive',
						'alt'   => trim( strip_tags( get_post_meta( get_post_thumbnail_id( $post->ID ), '_wp_attachment_image_alt', true ) ) ),
						'itemprop'	=> 'image',
					)
				);
		  		?>
			</figure>
		<?php } ?>
		<div  itemprop="articleBody"><?php the_content(); ?></div>
		<span class="clearfix"></span>
		<?php
		/**
		 * Arguments for wp_link_pages
		 *
		 * @link https://developer.wordpress.org/reference/functions/wp_link_pages/
		 * @var array
		 */
		$args = array(
			'before'	=> '<p class="text-muted lead"><b>' . __( 'Pages:', 'ItalyStrap' ) . '</b>',
			'after'		=> '</p>',
		);
		$args = apply_filters( 'italystrap_wp_link_pages_args', $args );

		wp_link_pages( $args );
		?>
		<p class="sr-only"><?php esc_attr_e( 'Last edit:', 'ItalyStrap' ); ?> <time datetime="<?php the_modified_time( 'Y-m-d' ) ?>" itemprop="dateModified"><?php the_modified_time( 'd F Y' ) ?></time></p>
		<span class="clearfix"></span>
		<?php
		/**
		 * Arguments for edit_post_link()
		 *
		 * @var array
		 */
		$args = array(
			/* translators: %s: Name of current post */
			'link_text'	=> __( 'Edit<span class="screen-reader-text"> "%s"</span>', 'ItalyStrap' ),
			'before'	=> '<span class="btn btn-sm btn-primary">',
			'after'		=> '</span>',
			);
		$args = apply_filters( 'italystrap_edit_post_link_args', $args );

		edit_post_link(
			sprintf(
				$args['link_text'],
				get_the_title()
			),
			$args['before'],
			$args['after']
		);
		?>
		<!-- <h3><?php esc_attr_e( 'Share this with your friends:', 'ItalyStrap' ); ?></h3> -->
		<!-- <textarea class="form-control" tabindex="4" rows="2"><?php the_permalink(); ?></textarea> -->
	</section><!-- /.entry-content -->

	<?php echo italystrap_ttr_wc(); // XSS ok.?>
	<span class="clearfix"></span>
	<?php get_template_part( 'template/content', 'author-info' );?>
	<meta itemprop="interactionCount" content="UserComments:<?php comments_number( 0, 1, '%' );?>" />
</article>
<?php
/**
 * Arguments for previous_post_link() and next_post_link()
 *
 * @var array
 */
$args = array(
	'previous_format'	=> '<li class="previous pager-prev"> %link',
	'previous_link'		=> '<i class="glyphicon glyphicon-arrow-left"></i> %title</li>',
	'next_format'		=> '<li class="next pager-next"> %link',
	'next_link'			=> '%title <i class="glyphicon glyphicon-arrow-right"></i></li>',
	);
$args = apply_filters( 'italystrap_previous_next_post_link_args', $args );
?>
<ul class="pager">
	<?php
	previous_post_link( $args['previous_format'], $args['previous_link'] );
	next_post_link( $args['next_format'], $args['next_link'] );
	?>
</ul>
<span class="clearfix"></span>
<hr>
