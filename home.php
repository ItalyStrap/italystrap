<?php
/**
 * The main template file.
 *
 * This is an example of a custom home page
 * In your home page will view a bootstrap slideshow with Custom Post Type "Prodotti" on the top of content
 * If the CPT Prodotti is empty the BT slide won't be showing
 * In the new CPT editor check meta box top-left if you want to show the new image product
 * The CPT must have a feautured image
 *
 * @example for loading carousel only if is not smarphone
 *          use if (!$detect->isMobile()){}
 *          It works also for any code
 *          In example here below the if is
 *          if ( $prodotti->have_posts() && ! $detect->isMobile() ):
 * @example You can also use css class hidden-xxs for hide element but it still remain in HTML
 */
get_header();

$prodotti = new WP_Query( array(	 'meta_key'			=>	'slide',
									 'meta_value' 		=> 	'on',
									 'post_type'		=>	'prodotti',
									));
if ( $prodotti->have_posts() && ! $detect->isMobile() ):
?>
<!-- Carousel -->
<section id="carousel">
	<div class="container">
		<div id="IndexCarousel" class="carousel slide">
			<ol class="carousel-indicators">
				<?php
				$active = 0;
				foreach ( $prodotti->posts as $post ) {
						$class = ( $active == 0 ) ? 'active' : '';
						echo  '<li data-target="#IndexCarousel" data-slide-to="' . $active . '" class="' . $class . '"></li>';
						$active++;
						}
				 ?>
			</ol>
			<div class="carousel-inner">
				<?php $active = 1; while ( $prodotti->have_posts() ) : $prodotti->the_post(); ?>
					<div class="item <?php if ($active == 1 ) : ?>active<?php endif; $active ++; ?>"  itemscope itemtype="http://schema.org/Article">
					  <?php the_post_thumbnail( 'slide' ); ?><meta  itemprop="image" content="<?php echo italystrap_thumb_url();?>"/>
					  <div class="container">
						<div class="carousel-caption">
							<h1><?php echo sanitize_text_field( get_post_meta($post->ID, 'title_headline', true) ); ?></h1>
						  <p class="lead" itemprop="text"><?php echo sanitize_text_field( get_post_meta($post->ID, 'headline', true) ); ?></p>
						  <p><a class="btn btn-large btn-primary" href="<?php the_permalink(); ?>" itemprop="url"><?php echo sanitize_text_field( get_post_meta($post->ID, 'call_to_action', true) ); ?></a></p>
						</div>
					  </div>
					</div>
				<?php endwhile;
				wp_reset_query();
				wp_reset_postdata();
				?>
			</div>
			<a class="left carousel-control" role="button" href="#IndexCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
			<a class="right carousel-control" role="button" href="#IndexCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
		</div><!-- / #IndexCarousel -->
		<hr>
	</div><!-- / .container -->
</section><!-- / .carousel -->

<?php
endif;

/**
 * This is the standard loop for show your article
 * In this case it is configured to show only 4 article because each article are configured to show using col-md-3 class
 */
?>

<!-- Main Content -->
<section id="main">
	<div class="container">
		<h3>Ultimi articoli</h3>
		<section class="row">
			<?php
				/**
				 * Example code: If there is a stycky post the loop show only 3 articles
				 */
				$sticky = get_option( 'sticky_posts' );
				if ( isset( $sticky[0] ) ) {
					$postperpage = 3;
				} else {
					$postperpage = 4;
				}
				query_posts( "posts_per_page=$postperpage" );
				if(have_posts()) :
				while(have_posts()) : the_post();
			?>
			<div class="col-md-3" itemscope itemtype="http://schema.org/Article">
				<?php if ( has_post_thumbnail() ) { ?>
				<a href="<?php the_permalink(); ?>" class="thumbnail" title="<?php the_title_attribute(); ?>">
					<?php
				  		the_post_thumbnail(
				  			'article-thumb-index',
				  			array(
				  				'class' => 'center-block img-responsive',
				  				'alt'   => trim( strip_tags( get_post_meta( get_post_thumbnail_id( $post->ID ), '_wp_attachment_image_alt', true ) ) ),
				  				) );

					?>
				</a>
				<meta  itemprop="image" content="<?php echo italystrap_thumb_url();?>"/>
				<?php } ?>
				<h4 class="item-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
					<footer>
						<ul class="list-inline">
							<li><small><time datetime="<?php the_time('Y-m-d') ?>" itemprop="datePublished"><?php the_time( get_option('date_format') ) ?></time></small></li>
							<li><small><?php _e('Author:', 'ItalyStrap'); ?> <span itemprop="author" itemscope itemtype="http://schema.org/Person"><?php the_author_posts_link(); ?></span></small></li>
						</ul>
					</footer>
					<div itemprop="text"><?php the_excerpt(); ?></div>
					<?php 
						if ( has_post_format('standard') ) {
							/**
							  * For more improvement see http://www.wproots.com/using-wordpress-post-formats-to-their-fullest/
							  * and see http://www.wproots.com/using-wordpress-post-formats-to-their-fullest/#comment-868
							  *
							  */
						}
					?>
			</div><!-- / .col-md-3 -->
			<?php
				endwhile;
				endif;
				wp_reset_query();
			?>
		</section><!-- / .row -->
		<hr>
    </div><!-- / .container -->
</section><!-- / #main -->

	<section id="index">
        <div class="container">
            <div class="row">
				<div class="col-md-8" itemscope itemtype="http://schema.org/CollectionPage">
				<?php

					if ( have_posts() ) : while ( have_posts() ) : the_post();

						get_template_part( 'loops/content', 'archive' );

					endwhile;

						bootstrap_pagination();

					else :

						get_template_part( 'loops/content', 'none');

					endif;
						wp_reset_query();
						wp_reset_postdata();
?>


				</div><!-- / .col-md-8 -->
				<?php get_sidebar(); ?> 
			</div><!-- / .row -->
		</div><!-- / .container -->
	</section><!-- / #index -->


<?php get_footer(); ?>