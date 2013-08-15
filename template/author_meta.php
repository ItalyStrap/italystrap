										<!-- AUTHOR -->
										<section class="margin-top-25 well" itemprop="author" itemscope itemtype="http://schema.org/Person">
											<div class="row-fluid">
												<div class="span2">
													<a href="<?php the_author_meta('url') ?>" rel="author" itemprop="url"><?php echo get_avatar( get_the_author_meta('ID'), 94, '$path/img/author_thumb.jpg', 'Avatar autore') ?></a>				
												</div>
												<div class="span10">
													<p itemprop="description"><?php the_author_meta( 'description' ) ?></p>
													<h4 itemprop="name"><?php the_author_posts_link(); ?></h4>
													<meta itemprop="image" content="<?php  $thumbnailUrl = get_avatar( get_the_author_meta('ID')); echo estraiUrlsGravatar($thumbnailUrl);?>"/>
												</div>
											</div>
										</section>