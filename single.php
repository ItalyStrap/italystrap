<?php
/**
 * The single template file.
 */
get_header(); ?> 
    <!-- Main Content -->
    <section>
    	<div class="container">
        	<div class="row">
                <div class="col-md-8">
				<?php create_breadcrumbs() ?>
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>				
									<article itemscope itemtype="http://schema.org/Article">
										<header class="page-header">
											<h1><a itemprop="url" href="<?php the_permalink(); ?>" title="<?php the_title_attribute() ?>" rel="bookmark">
											<span itemprop="headline"><?php the_title(); ?></span></a></h1>
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
										<section class="margin-bottom-25">
											<div class="margin-bottom-25 thumbnail">
												<?php if ( has_post_thumbnail() ) {
															echo "<figure>";
															the_post_thumbnail( 'article-thumb', array('class' => 'img-rounded img-responsive') );
															echo "</figure>";} ?>
											</div>
												<div  itemprop="articleBody"><?php the_content(); ?></div>
												<p class="label label-info">Ultima modifica: <time datetime="<?php the_modified_time('Y-m-d') ?>" itemprop="dateModified"><?php the_modified_time('d F Y') ?></time></p>
												<span class="clearfix"></span>
													<?php edit_post_link( __( 'Modifica articolo', 'ItalyStrap' ), '<span class="btn btn-sm btn-primary margin-top-25">', '</span>' ); ?>
										</section>
										<?php get_template_part( 'template/social-button');?>
										<?php echo italystrap_ttr_wc();?>
										<span class="clearfix"></span>
										<?php get_template_part( 'template/author_meta');?>
										<meta itemprop="interactionCount" content="UserComments:<?php comments_number(0, 1, '%');?>" />
									</article>
										<ul class="pager">
											<li class="previous"><?php previous_post_link('%link', '<i class="glyphicon glyphicon-arrow-left"></i> %title');?></li>
											<li class="next"><?php next_post_link('%link', '%title <i class="glyphicon glyphicon-arrow-right"></i>') ?></li>
										</ul>
										<span class="clearfix"></span>
										<hr>
										<?php show_related_posts();?>
					<?php endwhile; else: ?>
						<?php get_template_part( 'template/non-trovato');?>
					<?php endif; ?>				
					<hr>
					<?php comments_template(); ?> 	
   
                </div>	
				<?php get_sidebar(); ?> 
            </div>
		</div>
    </section><!-- #content -->
   
<?php get_footer(); ?>