<article itemscope itemtype="http://schema.org/Article" id="post-<?php the_ID(); ?>" <?php post_class( 'sitemap-html' ); ?>>
	<header class="page-header">
		<h1><a itemprop="url" href="<?php the_permalink(); ?>" title="<?php the_title_attribute() ?>" rel="bookmark">
		<span itemprop="headline"><?php the_title(); ?></span></a></h1>
	</header>
	<footer>
		<?php get_template_part('template/meta'); ?>
	</footer>
	<?php if( is_preview() ) : ?>  
		<div class="alert alert-info">  
			<?php _e( '<strong>Note:</strong> You are previewing this post. This post has not yet been published.', 'ItalyStrap' ); ?>  
		</div>  
	<?php endif; ?>
	<?php

        if ( class_exists('ItalyStrapHTMLSitemaps') ){

        	// $args = array(
        	// 	'print' => 1
        	// 	);

        	new ItalyStrapHTMLSitemaps( $args );
        }
        else
            _e( 'Please, install <a href="https://wordpress.org/plugins/italystrap/" target="_blank">the ItalyStrap plugin</a> for Sitemap HTML feauture', 'ItalyStrap' );

	?>
</article>
<hr>