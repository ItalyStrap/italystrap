<?php
/*
 * Template Name: blog
 */
get_header();?>
	<section id="blog">
        <div class="container">
            <div class="row">
				<div class="col-md-8" itemscope itemtype="http://schema.org/CollectionPage">
					<?php create_breadcrumbs() ?>
								<?php
								query_posts('cat=-&paged='.$paged);
								if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
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
																  <?php echo "<figure>";
																		the_post_thumbnail( 'article-thumb', array('class' => 'center-block img-responsive') );
																		echo "</figure>";?>
																</div>
															<?php } ?>
													<div  itemprop="text"><?php the_excerpt(); ?></div>
														<p class="label label-info">Ultima modifica: <time datetime="<?php the_modified_time('Y-m-d') ?>" itemprop="dateModified"><?php the_modified_time('d F Y') ?></time></p>
														<span class="clearfix"></span>
													</section>
														<?php echo italystrap_ttr_wc();?>
														<span class="clearfix"></span>
												</article>
												<hr>
									<?php endwhile;?>
										<?php bootstrap_pagination();?>
									<?php else : ?>
										<?php get_template_part( 'template/non-trovato');?>
								<?php endif;?>
							<?php wp_reset_query();?>
				</div>
				<?php get_sidebar(); ?> 
			</div>
		</div>
	</section>	
<?php get_footer(); ?>