<?php
//http://gabrieleromanato.com/2012/02/wordpress-visualizzare-i-post-correlati-senza-plugin/
function show_related_posts() {
		global $post;

		$tags = wp_get_post_tags($post->ID);
		
		if($tags) {
		
  		$first_tag = $tags[0]->term_id;
  		$args = array(
    		'tag__in' => array($first_tag),
    		'post__not_in' => array($post->ID),
    		'showposts'=> 4,
    		'ignore_sticky_posts'=>1
   		);
  	$post_correlati = new WP_Query($args);
  		if( $post_correlati->have_posts() ) {
          echo '<h3>Potrebbero interessarti</h3>' . "\n";
  		    echo '<div class="row" itemscope itemtype="http://schema.org/Article">' . "\n";
    		while ($post_correlati->have_posts()) : $post_correlati->the_post(); ?>
				<span class="col-md-3 col-xs-6">
					<?php if ( has_post_thumbnail() ) {
							echo "<figure><span class='thumbnail'>";
							the_post_thumbnail( 'thumbnail', array('class' => 'center-block  img-responsive') );
							echo "</span></figure>";} ?>
							<meta  itemprop="image" content="<?php echo italystrap_thumb_url();?>"/>
					<p class="text-center"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" itemprop="url"><span itemprop="name"><strong><?php the_title(); ?></strong></span></a></p>
				</span>
      	<?php
    		endwhile;
    		echo '</div>' . "\n";
    		 wp_reset_query();
  		}
  	  }
}
?>