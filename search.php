<?php
/**
 * The search template file.
 */
get_header();?>
	<section id="search post" <?php post_class('class-name'); ?>>
        <div class="container">
            <div class="row">
				<div class="col-md-8" itemscope itemtype="http://schema.org/SearchResultsPage">
					<?php create_breadcrumbs() ?>
								<?php
								if ( have_posts() ) : ?>
									
									<header class="page-header">
										<h1 itemprop="headline"><?php printf( __( 'Search result of: %s', 'twentytwelve' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
									</header>

									<?php while ( have_posts() ) : the_post(); ?>
									
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
														<p class="label label-info"><?php _e('Last edit:', 'ItalyStrap'); ?> <time datetime="<?php the_modified_time('Y-m-d') ?>" itemprop="dateModified"><?php the_modified_time('d F Y') ?></time></p>
														<span class="clearfix"></span>
													</section>
													<?php echo italystrap_ttr_wc();?>
												</article> 
												<hr>
									<?php endwhile;?>
										<?php else : ?>
											<?php get_template_part( 'template/non-trovato');?>
								<?php endif;?>
								<?php wp_reset_query(); ?>
							<?php bootstrap_pagination();?>
				</div>
				<?php get_sidebar(); ?> 
			</div>
		</div>
	</section>
<?php get_footer(); ?>