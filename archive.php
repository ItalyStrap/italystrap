<?php
/**
 * The archive template file.
 */
get_header(); ?>
	<section id="archive">
        <div class="container">
            <div class="row">
				<div class="col-md-8" itemscope itemtype="http://schema.org/CollectionPage">
					<?php create_breadcrumbs(); ?>
					<header class="page-header">
						<?php
						the_archive_title('<h2 itemprop="headline">', '</h2>');
						the_archive_description('<div class="alert alert-info" role="alert" itemprop="description">', '</div>');

						if ( is_post_type_archive() ) {
							// Display or retrieve title for a post type archive.
							// This is optimized for archive.php and archive-{posttype}.php template files for displaying the title of the post type.

							$cpt_description = get_post_type_object( get_post_type() );
							if ($cpt_description) { ?>
								<div class="alert alert-info" role="alert" itemprop="description">
									<?php echo $cpt_description->description ;?>
								</div>
						<?php }
						} ?>
					</header>
				<?php
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
	</section><!-- / #archive -->
<?php get_footer(); ?>