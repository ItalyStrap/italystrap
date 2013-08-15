<!-- Facebook Opengraph -->
	<meta property="fb:admins" content="xxxxxxxxxx" />
	<meta property="fb:admins" content="xxxxxxxxxx" />
	<meta property="fb:app_id" content="xxxxxxxxxx">
	<?php if (is_home() || is_front_page()) { ?>	
	<!-- Facebook Opengraph Home -->
    <meta property="og:site_name" content="<?php bloginfo('name'); ?>" />
    <meta property="og:description" content="<?php bloginfo('description'); ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="<?php echo italystrap_logo();?>" /><!-- Min image size 200x200px -->
	<meta property="og:url" content="<?php bloginfo( 'wpurl' ); ?>" />
	<?php } ?>	
	<?php if (is_singular() ) {?>
	<!-- Facebook Opengraph Single or Page -->
	<meta property="og:title" content="<?php the_title(); ?>" />
	<meta property="og:type" content="article" />
	<meta property="og:image" content="<?php echo italystrap_thumb_url() ?>" />
	<meta property="og:url" content="<?php the_permalink(); ?>" />
										<?php } ?>										
	<?php if (is_page() || is_single() && ( function_exists('aioseop_load_modules'))) {
	//Codice per All in One Seo pack
	$post_aioseo_desc = get_post_meta($post->ID, '_aioseop_description', true);
	if($post_aioseo_desc){ ?>
	<!-- Facebook Opengraph Single or Page -->
	<meta property="og:description" content="<?php echo stripcslashes($post_aioseo_desc); ?>" />
	<?php }}?>
	<!-- End Facebook Opengraph -->