<?php
/**
 * The main template file.
 */
get_header(); ?>
	<!-- Carousel
	================================================== -->
	<section>
	<div class="container">
		<div id="myCarousel" class="carousel slide">
			<div class="carousel-inner">
				<?php $prodotti = new WP_Query(array('meta_key'			=>	'call_to_action'  ,
													 'category_name'	=>	'Slide',
													 'post_type'		=>	'prodotti',
													 'posts_per_page' 	=> 	4
													));?>
							<?php $active = 0; ?>
							<?php while ($prodotti->have_posts()) : $prodotti->the_post(); ?>				
								<div class="item <?php if ($active == 1 ) : ?>active
												<?php endif;
												$active ++; ?>"  itemscope itemtype="http://schema.org/Article">
								  <?php the_post_thumbnail( 'slide' ); ?><meta  itemprop="image" content="<?php echo italystrap_thumb_url();?>"/>
								  <div class="container">
									<div class="carousel-caption">
									  <p class="lead" itemprop="text"><?php echo get_post_meta($post->ID, 'headline', true); ?></p>
									  <a class="btn btn-large btn-primary" href="<?php the_permalink(); ?>" itemprop="url"><?php echo get_post_meta($post->ID, 'call_to_action', true); ?></a>
									</div>
								  </div>
								</div>
							<?php endwhile;
							wp_reset_query();
							wp_reset_postdata();
							?>
			</div>
				<a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
				<a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
		</div>
	</div>
	</section><!-- /.carousel -->

    <!-- Main Content -->
    <section>
    	<div class="container">
			<h3>Ultimi articoli</h3>
				<section class="row-fluid">
					<?php query_posts( 'posts_per_page=4' );
							if(have_posts()) :
							while(have_posts()) : the_post();
					?>
						<div class="span3" itemscope itemtype="http://schema.org/Article">
							<?php if ( has_post_thumbnail() ) { ?>
							<a href="<?php the_permalink(); ?>" class="thumbnail" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'article-thumb-index' ); ?>
							</a><meta  itemprop="image" content="<?php echo italystrap_thumb_url();?>"/>
							<?php } ?>
							<h4 class="item-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
								<footer>
									<ul class="inline">
										<li><small>Del: <time datetime="<?php the_time('Y-m-d') ?>" itemprop="datePublished"><?php the_time('d-m-Y') ?></time></small></li>
										<li><small>Autore: <span itemprop="author" itemscope itemtype="http://schema.org/Person"><?php the_author_posts_link(); ?></span></small></li>
									</ul>
								</footer>
								<div itemprop="text"><?php the_excerpt(); ?></div>
						</div>
						<?php
							endwhile;
							endif;
							wp_reset_query();
						?>
				</section>
        </div>
	</section><!-- #content -->
<?php get_footer(); ?>