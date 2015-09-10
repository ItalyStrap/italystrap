<?php
/**
 * The archive template file.
 */
get_header(); ?>
<!-- Main Content -->
	<section id="archive">
		<?php do_action( 'content_open' ); ?>
		<div class="container">
			<?php do_action( 'content_container_open' ); ?>
			<div class="row">
				<div class="col-md-8" itemscope itemtype="http://schema.org/CollectionPage">
					<?php do_action( 'content_col_open' ); ?>
					<header class="page-header">
						<?php
						the_archive_title('<h2 itemprop="headline">', '</h2>');
						the_archive_description('<div class="well" role="alert" itemprop="description"><p>', '</p></div>');

						if ( is_post_type_archive() ) {
								// Display or retrieve title for a post type archive.
								// This is optimized for archive.php and archive-{posttype}.php template files for displaying the title of the post type.

							$cpt_description = get_post_type_object( get_post_type() );
							if ($cpt_description) { ?>
							<div class="well" role="alert" itemprop="description"><p>
								<?php echo $cpt_description->description ;?>
							</p></div>
							<?php }
						} ?>
					</header>
					<?php
					if ( have_posts() ) : while ( have_posts() ) : the_post();

					get_template_part( 'loops/content', 'post' );

					endwhile;
					else : 
						get_template_part( 'loops/content', 'none');
					endif;
					wp_reset_query(); 
					bootstrap_pagination();
					do_action( 'content_col_closed' ); ?>
				</div><!-- / .col-md-8 -->
				<?php get_sidebar(); ?> 
			</div><!-- / .row -->
			<?php do_action( 'content_container_closed' ); ?>
		</div><!-- / .container -->
		<?php do_action( 'content_closed' ); ?>
	</section><!-- / #archive -->
	
<?php get_footer(); ?>