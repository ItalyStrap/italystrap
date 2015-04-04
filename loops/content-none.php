<article>
	<header class="page-header">
		<h1 itemprop="headline">
			<?php _e( 'Damn, what you were looking for is not there', 'ItalyStrap' ); ?>
		</h1>
	</header>
		<p>
			<?php _e( 'Search again with the form below.', 'ItalyStrap' ); ?>
		</p>
		<?php get_search_form();

		if ( $GLOBALS['italystrap_options']['default_404'] )
			$img_404 = $GLOBALS['italystrap_options']['default_404'];
		else
			$img_404 = get_template_directory_uri() . '/img/404.jpg';
		
		?>
		<p class="margin-top-25">
			<img src="<?php echo $img_404; ?>" alt="Page 404" class="img-responsive center-block">
		</p>
</article><!-- #post-0 -->
