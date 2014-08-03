<?php
/**
 * The archive template file.
 */
get_header(); ?>
	<section id="archive">
        <div class="container">
            <div class="row">
				<div class="col-md-8" itemscope itemtype="http://schema.org/CollectionPage">
					<?php create_breadcrumbs() ?>
							<header class="page-header">
								<?php
								if ( have_posts() ) : ?>
									<?php if( is_tag() ) { ?>
										<h2 itemprop="headline">Archivio per il tag <?php single_tag_title(); ?></h2>
											<?php if ( tag_description() ) : // Show an optional tag description ?>
												<div class="alert alert-info" role="alert" itemprop="description"><?php echo tag_description(); ?></div>
											<?php endif; ?>
									<?php } elseif (is_category()) { ?>
										<h2 itemprop="headline">Archivio per la categoria <?php single_cat_title(); ?></h2>
											<?php if ( category_description() ) : // Show an optional category description ?>
												<div class="alert alert-info" role="alert" itemprop="description"><?php echo category_description(); ?></div>
											<?php endif; ?>
									<?php } elseif (is_day()) { ?>
										<h2 itemprop="headline">Archivio per il giorno <?php the_time('j F Y'); ?></h2>
									<?php } elseif (is_month()) { ?>
										<h2 itemprop="headline">Archivio per il mese di <?php the_time('F Y'); ?></h2>
									<?php } elseif (is_year()) { ?>
										<h2 itemprop="headline">Archivio per l'anno <?php the_time('Y'); ?></h2>
									<?php } elseif ( is_post_type_archive() ) {
										// Display or retrieve title for a post type archive.
										// This is optimized for archive.php and archive-{posttype}.php template files for displaying the title of the post type.
									?><h2 itemprop="headline"><?php post_type_archive_title(); ?></h2>
									<?php $cpt_description = get_post_type_object( get_post_type() );
										if ($cpt_description) : ?>
											<div class="alert alert-info" role="alert" itemprop="description">
												<?php echo $cpt_description->description ;?>
											</div>
									<?php endif; ?>
									<?php } ?>
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