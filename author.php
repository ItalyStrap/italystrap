<?php get_header(); ?>
	<section id="author-page">
        <div class="container">
            <div class="row">
				<div class="col-md-8">
					<?php create_breadcrumbs() ?>
						<header class="page-header" itemscope itemtype="http://schema.org/Person">
							<!-- This sets the $curauth variable -->
							<?php $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));?>
							<h2>Articoli di: <span itemprop="name"><?php echo $curauth->nickname; ?></span></h2>
								<div class="row">
									<div class="col-sm-2">
										<?php 
										if (!empty($curauth->avatar)){
											echo '<img src="' . $curauth->avatar . '" alt="avatar autore" class="img-circle img-responsive" width="94" height="94" />';
											echo '<meta itemprop="image" content="' . $curauth->avatar . '">';
											};
										?>
									</div>
									<div class="col-sm-10">
										<?php if($curauth->description != "") { ?>
												<p itemprop="description"><?php echo $curauth->description; ?></a></p>
										<?php } ?>
										<?php if($curauth->user_url != "") { ?>
												<p itemprop="url"><strong>Sito WEB:</strong> <a href="<?php echo $curauth->user_url; ?>"><?php echo $curauth->user_url; ?></a></p>
										<?php } ?>
										<ul class="list-inline">
											<?php
											if (!empty($curauth->twitter)){
											echo '<li><a href="' . $curauth->twitter . '" title="Twitter" rel="me" class="sprite twitter"></a></li>';
											};
											if (!empty($curauth->fb_profile)){
											echo '<li><a href="' . $curauth->fb_profile . '" title="Facebook" rel="me" class="sprite facebook"></a></li>';
											};
											if (!empty($curauth->google_profile)){
											echo '<li><a href="' . $curauth->google_profile . '" title="Google+" rel="me" class="sprite googleplus"></a></li>';
											};
											if (!empty($curauth->skype)){
											echo '<li><a href="skype:' . $curauth->skype . '?chat" title="skype" rel="me" class="sprite skype"></a></li>';
											};
											if (!empty($curauth->google_page)){
											echo '<li><a href="' . $curauth->google_page . '" title="Google Business page" rel="me" class="sprite googleplus"></a></li>';
											};
											if (!empty($curauth->linkedIn)){
											echo '<li><a href="' . $curauth->linkedIn . '" title="linkedIn" rel="me" class="sprite linkedin"></a></li>';
											};
											if (!empty($curauth->pinterest)){
											echo '<li><a href="' . $curauth->pinterest . '" title="pinterest" rel="me" class="sprite pinterest"></a></li>';
											};
											?>
										</ul>
									</div>
								</div>
						</header>
							<div  itemscope itemtype="http://schema.org/CollectionPage">
								<?php
								query_posts('cat=-&paged='.$paged);
								if ( have_posts() ) : ?>
									
									<?php while ( have_posts() ) : the_post(); ?>
									
												<article>
													<header class="title">
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
													</section>
														<?php echo italystrap_ttr_wc();?>
												</article> 
												<hr>
									<?php endwhile;?>
										<?php else : ?>
											<?php get_template_part( 'template/non-trovato');?>
								<?php endif;?>
							<?php wp_reset_query(); ?>
							</div>
						<?php bootstrap_pagination();?>
				</div>
				<?php get_sidebar(); ?> 
			</div>
		</div>
</section>	
<?php get_footer(); ?>