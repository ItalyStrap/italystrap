<?php
/**
 * The author template file.
 */
get_header(); ?>
	<section id="author-page">
        <div class="container">
            <div class="row">
				<div class="col-md-8" itemscope itemtype="http://schema.org/CollectionPage">
					<?php create_breadcrumbs(); ?>
					<!-- This sets the $curauth variable -->
					<?php $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));?>
					<div class="row" itemprop="author" itemscope itemtype="http://schema.org/Person">

						<h2><?php echo $curauth->nickname; ?></h2>
						<div class="col-sm-2">
							<?php 
							if ($curauth->avatar){ ?>
								<img src="<?php echo $curauth->avatar; ?>" alt="avatar autore" class="img-circle img-responsive" width="96" height="96" itemprop="image" />
								<meta itemprop="image" content="<?php echo $curauth->avatar; ?>">
							<?php }else{

								echo italystrap_get_avatar( get_the_author_meta('ID'), 94, NULL, $curauth->nickname, 'img-circle img-responsive' );
							};?>
						</div><!-- / .col-sm-2 -->
						<div class="col-sm-10">
							<?php if($curauth->description) { ?>
									<p itemprop="description"><?php echo $curauth->description; ?></a></p>
							<?php } ?>
							<?php if($curauth->user_url) { ?>
									<p itemprop="url"><strong><?php _e('Web site:', 'ItalyStrap'); ?></strong> <a href="<?php echo $curauth->user_url; ?>"><?php echo $curauth->user_url; ?></a></p>
							<?php } ?>
							<ul class="list-inline">
							<?php
							if ( $curauth->twitter ){ ?>
								<li><a href="<?php echo $curauth->twitter; ?>" title="Twitter" rel="me" class="sprite twitter"></a></li>
							<?php }
							if ( $curauth->fb_profile ){ ?>
								<li><a href="<?php echo $curauth->fb_profile; ?>" title="Facebook" rel="me" class="sprite facebook"></a></li>
							<?php }
							if ( $curauth->google_profile ){ ?>
								<li><a href="<?php echo $curauth->google_profile; ?>" title="Google+" rel="me" class="sprite googleplus"></a></li>
							<?php }
							if ( $curauth->skype ){ ?>
								<li><a href="skype:<?php echo $curauth->skype; ?>?chat" title="skype" rel="me" class="sprite skype"></a></li>
							<?php }
							if ( $curauth->google_page ){ ?>
								<li><a href="<?php echo $curauth->google_page; ?>" title="Google Business page" rel="me" class="sprite googleplus"></a></li>
							<?php }
							if ( $curauth->linkedIn ){ ?>
								<li><a href="<?php echo $curauth->linkedIn; ?>" title="linkedIn" rel="me" class="sprite linkedin"></a></li>
							<?php }
							if ( $curauth->pinterest ){ ?>
								<li><a href="<?php echo $curauth->pinterest; ?>" title="pinterest" rel="me" class="sprite pinterest"></a></li>
							<?php }
							?>
							</ul>
						</div><!-- / .col-sm-10 -->
					</div><!-- / .row schema -->
					<header class="page-header">
						<h2 itemprop="name"><?php the_archive_title(); ?></h2>
						<?php the_archive_description(); ?>
					</header>
					<?php
					query_posts( 'cat=-&paged=' . $paged );
					if ( have_posts() ) : while ( have_posts() ) : the_post(); 

						get_template_part( 'loops/content', 'archive' );

						endwhile;
						else :
							get_template_part( 'loops/content', 'none');
					endif;
						wp_reset_query();
						bootstrap_pagination();
					?>
				</div><!-- / .col-md-8 -->
				<?php get_sidebar(); ?> 
			</div><!-- / .row -->
		</div><!-- / .container -->
	</section><!-- / #author-page -->
<?php get_footer(); ?>