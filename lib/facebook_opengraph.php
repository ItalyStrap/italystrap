<!-- Facebook Opengraph -->
	<meta property="fb:admins" content="xxxxxxxxxx" />
	<meta property="fb:admins" content="xxxxxxxxxx" />
	<meta property="fb:app_id" content="xxxxxxxxxx">
	<meta property="og:locale" content="it_IT"/>
	<?php if (is_home() || is_front_page()) { ?>	
<!-- Facebook Opengraph Home -->
    <meta property="og:site_name" content="<?php bloginfo('name'); ?>" />
    <meta property="og:description" content="<?php bloginfo('description'); ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="<?php echo italystrap_thumb_url();?>" /><!-- Min image size 200x200px -->
    <?php 
    /**
     * Get the current page (For custom post category)
     * @link https://core.trac.wordpress.org/ticket/9963
     */
    ?>
	<meta property="og:url" content="<?php echo $current_url = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />
	<?php } ?>	
	<?php if ( is_singular() ) {?>
<!-- Facebook Opengraph Single or Page -->
	<meta property="og:title" content="<?php the_title(); ?>" />
	<meta property="og:type" content="article" />
	<meta property="og:image" content="<?php echo italystrap_thumb_url() ?>" />
	<meta property="og:url" content="<?php the_permalink(); ?>" />
	<meta property="og:description" content="<?php echo italystrap_open_graph_desc(); ?>" />
										<?php } ?>
<!-- End Facebook Opengraph -->