<!-- Twitter Cards -->
<?php
if ( is_singular() ) {?>
	<meta name="twitter:card" value="summary_large_image" />
	<meta name="twitter:domain" content="<?php bloginfo('name'); ?>"/>
	<meta name="twitter:url" value="<?php echo get_permalink(); ?>" />
	<meta name="twitter:title" value="<?php echo get_the_title(); ?>" />
	<meta name="twitter:description" value="<?php echo italystrap_open_graph_desc(); ?>" />
	<meta name="twitter:image" value="<?php echo italystrap_thumb_url(); ?>" />
	<meta name="twitter:site" value="@overclokk" />
	<meta name="twitter:creator" content="@overclokk"/>
<?php }?>
<!-- End Twitter Cards -->
