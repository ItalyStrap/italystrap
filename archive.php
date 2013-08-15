<?php
/**
 * The archive template file.
 */
get_header(); ?>
	<section>
        <div class="container">
            <div class="row-fluid">
				<div class="span8" itemscope itemtype="http://schema.org/CollectionPage">
					<?php create_breadcrumbs() ?>
							<header class="page-header">
								<?php
								if ( have_posts() ) : ?>
									<?php if( is_tag() ) { ?>
										<h2 itemprop="headline">Archivio per il tag <?php single_tag_title(); ?></h2>
											<?php if ( tag_description() ) : // Show an optional tag description ?>
												<div itemprop="description"><?php echo tag_description(); ?></div>
											<?php endif; ?>
									<?php } elseif (is_category()) { ?>
										<h2 itemprop="headline">Archivio per la categoria <?php single_cat_title(); ?></h2>
											<?php if ( category_description() ) : // Show an optional category description ?>
												<div itemprop="description"><?php echo category_description(); ?></div>
											<?php endif; ?>
									<?php } elseif (is_day()) { ?>
										<h2 itemprop="headline">Archivio per il giorno <?php the_time('j F Y'); ?></h2>
									<?php } elseif (is_month()) { ?>
										<h2 itemprop="headline">Archivio per il mese di <?php the_time('F Y'); ?></h2>
									<?php } elseif (is_year()) { ?>
										<h2 itemprop="headline">Archivio per l'anno <?php the_time('Y'); ?></h2>
									<?php } ?>
							</header>	
									<?php while ( have_posts() ) : the_post(); ?>
												<article>
													<header>
														<h2><a itemprop="url" href="<?php the_permalink(); ?>" title="<?php the_title_attribute() ?>" rel="bookmark"><span itemprop="name"><?php the_title(); ?></span></a></h2>
													</header>
													<footer>
														<ul class="inline">
															<li>Del: <time datetime="<?php the_time('Y-m-d') ?>" itemprop="datePublished"><?php the_time('d-m-Y') ?></time></li>
															<li>Autore: <span itemprop="author" itemscope itemtype="http://schema.org/Person"><?php the_author_posts_link(); ?></span></li>
															<li><?php comments_number( '0 risposte', '1 risposta', '% risposte' ); ?></li>
															<?php the_tags('<li itemprop="keywords">Tags: ',' - ' , '</li>'); ?>
														</ul>
													</footer>
													<meta  itemprop="image" content="<?php echo italystrap_thumb_url();?>"/>
													<section>
														<div class="margin-bottom-25">
															<?php if ( has_post_thumbnail() ) {
																		echo "<figure>";
																		the_post_thumbnail( 'article-thumb', array('class' => 'img-polaroid') );
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