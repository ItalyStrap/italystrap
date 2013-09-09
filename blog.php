<?php
/*
 * Template Name: blog
 */
get_header();?>
	<section>
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
														<ul class="list-inline">
															<li>Del: <time datetime="<?php the_time('Y-m-d') ?>" itemprop="datePublished"><?php the_time('d-m-Y') ?></time></li>
															<li>Autore: <span itemprop="author" itemscope itemtype="http://schema.org/Person"><?php the_author_posts_link(); ?></span></li>
															<li><?php comments_number( '0 risposte', '1 risposta', '% risposte' ); ?></li>
															<li><?php the_category('&');?></li>
															<?php the_tags('<li itemprop="keywords">Tags: ',' - ' , '</li>'); ?>
														</ul>
													</footer>
													<meta  itemprop="image" content="<?php echo italystrap_thumb_url();?>"/>
													<section>
														<div class="margin-bottom-25">
															<?php if ( has_post_thumbnail() ) {
																		echo "<figure>";
																		the_post_thumbnail( 'article-thumb', array('class' => 'img-polaroid lazy') );
																		echo "</figure>";} ?>
														</div>
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
