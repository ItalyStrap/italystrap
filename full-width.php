<?php
/*
Template Name: Full-width
*/
get_header(); ?>
    <!-- Main Content -->
    <section id="full-width">
    	<div class="container">
        	<div class="row">
                <div class="col-md-12">
				<?php create_breadcrumbs() ?>
					<?php if (have_posts()) :  while (have_posts()) : the_post(); ?>
									<article itemscope itemtype="http://schema.org/Article">
										<header class="page-header">
											<h1 class="text-center"><a itemprop="url" href="<?php the_permalink(); ?>" title="<?php the_title_attribute() ?>" rel="bookmark">
											<span itemprop="headline"><?php the_title(); ?></span></a></h1>
										</header>
										<footer>
											<?php get_template_part('template/meta'); ?>
										</footer>
										<meta  itemprop="image" content="<?php echo italystrap_thumb_url();?>"/>
										<section class="margin-bottom-25">
															<?php if ( has_post_thumbnail() ) { ?>
																<div class="margin-bottom-25 thumbnail">
																  <?php echo "<figure>";
																		the_post_thumbnail( 'full-width', array('class' => 'center-block img-responsive') );
																		echo "</figure>";?>
																</div>
															<?php } ?>
												<div  itemprop="articleBody"><?php the_content(); ?></div>
												<p class="label label-info"><?php _e('Last edit:', 'ItalyStrap'); ?> <time datetime="<?php the_modified_time('Y-m-d') ?>" itemprop="dateModified"><?php the_modified_time('d F Y') ?></time></p>
												<span class="clearfix"></span>
													<?php edit_post_link( __( 'Edit', 'ItalyStrap' ), '<span class="btn btn-sm btn-primary margin-top-25">', '</span>' ); ?>
										</section>
										<?php get_template_part( 'template/social-button');?>
										<?php echo italystrap_ttr_wc();?>
										<span class="clearfix"></span>
										<?php get_template_part( 'template/author_meta');?>
										<meta itemprop="interactionCount" content="UserComments:<?php comments_number(0, 1, '%');?>" />
									</article> 				
					<?php endwhile; else: ?>
						<?php get_template_part( 'template/non-trovato');?>
					<?php endif; ?>				
					<hr>
					<?php comments_template(); ?> 	
   
                </div>
            </div>
		</div>
    </section><!-- #content -->
   
<?php get_footer(); ?>