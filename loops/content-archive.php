<article>
	<header>
		<h2><a itemprop="url" href="<?php the_permalink(); ?>" title="<?php the_title_attribute() ?>" rel="bookmark"><span itemprop="name"><?php the_title(); ?></span></a></h2>
	</header>
	<footer>
		<?php get_template_part('template/meta'); ?>
	</footer>
	<meta  itemprop="image" content="<?php echo italystrap_thumb_url();?>"/>
	<section>
		<?php if ( has_post_thumbnail() ) { ?>
			<div class="margin-bottom-25 thumbnail">
				<figure>
			  		<?php
			  		the_post_thumbnail(
			  			'article-thumb',
			  			array(
			  				'class' => 'center-block img-responsive',
			  				'alt'   => get_post_meta( get_post_thumbnail_id( $post->ID ), '_wp_attachment_image_alt', true ),
			  				) );
			  		?>
				</figure>
			</div>
		<?php } ?>
		<div  itemprop="text"><?php the_excerpt(); ?></div>
		<p class="label label-info"><?php _e('Last edit:', 'ItalyStrap'); ?> <time datetime="<?php the_modified_time('Y-m-d') ?>" itemprop="dateModified"><?php the_modified_time('d F Y') ?></time></p>
		<span class="clearfix"></span>
	</section>
		<?php echo italystrap_ttr_wc();?>
		<span class="clearfix"></span>
</article>
<hr>