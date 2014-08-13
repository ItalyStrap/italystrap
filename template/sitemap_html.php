<?php
//http://yoast.com/html-sitemap-wordpress/
?>
<h2 itemprop="name"><?php _e('Authors:', 'ItalyStrap'); ?></h2>
<meta itemprop="itemListOrder" content="Descending" />
	<ul>
		<?php wp_list_authors( array( 'exclude_admin' => false, ));?>
	</ul>
<h2 itemprop="name"><?php _e('Pages:', 'ItalyStrap'); ?></h2>
<meta itemprop="itemListOrder" content="Descending" />
	<ul>
		<?php
		// Add pages you'd like to exclude in the exclude here
		wp_list_pages( array( 'exclude' 	=> '',
							  'title_li' 	=> '',
								)
						  );?>
	</ul>
<h2 itemprop="name"><?php _e('Articles:', 'ItalyStrap'); ?></h2>
<meta itemprop="itemListOrder" content="Descending" />
	<ul>
		<?php
		// Add categories you'd like to exclude in the exclude here
		$cats = get_categories('exclude=');
		foreach ($cats as $cat) {
		  echo "<li><h3 itemprop='name'>".$cat->cat_name."</h3>";
		  echo "<ul>";
		  query_posts('posts_per_page=-1&cat='.$cat->cat_ID);
		  while(have_posts()) {
			the_post();
			$category = get_the_category();
			// Only display a post link once, even if it's in multiple categories
			if ($category[0]->cat_ID == $cat->cat_ID) {
			  echo '<li itemprop="itemListElement"><a href="'.get_permalink().'" itemprop="url">'.get_the_title().'</a></li>';
			}
		  }
		  echo "</ul>";
		  echo "</li>";
		}
		?>
	</ul>
<?php
foreach( get_post_types( array('public' => true) ) as $post_type ) {
  if ( in_array( $post_type, array('post','page','attachment') ) )
    continue;

  $pt = get_post_type_object( $post_type );

  echo '<h2 itemprop="name">'.$pt->labels->name.'</h2><meta itemprop="itemListOrder" content="Descending" />';
  echo '<ul>';

  query_posts('post_type='.$post_type.'&posts_per_page=-1');
  while( have_posts() ) {
    the_post();
    echo '<li itemprop="itemListElement"><a href="'.get_permalink().'" itemprop="url">'.get_the_title().'</a></li>';
  }

  echo '</ul>';
}
?>