<!DOCTYPE html>
<!--[if lt IE 7]>		<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="it-IT" prefix="og: http://ogp.me/ns#"> <![endif]-->
<!--[if IE 7]>			<html class="no-js lt-ie9 lt-ie8" lang="it-IT" prefix="og: http://ogp.me/ns#"> <![endif]-->
<!--[if IE 8]>			<html class="no-js lt-ie9" lang="it-IT" prefix="og: http://ogp.me/ns#"> <![endif]-->
<!--[if gt IE 8]><!-->	<html class="no-js" lang="it-IT" prefix="og: http://ogp.me/ns#"> <!--<![endif]-->
<head>
	<meta charset="UTF-8" >
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php wp_title('|', true, 'right'); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
<?php get_template_part( 'lib/facebook_opengraph' ); ?>
<?php get_template_part( 'lib/twitter_card' ); ?>

<?php wp_head();?>
</head>
<body>
<div class="wrapper">
    <header>
		<nav  class="navbar-wrapper" role="navigation">
			<div class="container" itemscope itemtype="http://schema.org/SiteNavigationElement">
				<div class="navbar navbar-inverse navbar-relative-top">
					<div class="container">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<span itemprop="publisher" itemscope itemtype="http://schema.org/Organization">
								<a class="navbar-brand" href="<?php echo home_url('/'); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home" itemprop="url"><span itemprop="name"><?php bloginfo('name'); ?></span></a>
								<meta  itemprop="image" content="<?php echo italystrap_logo();?>"/>
							</span>
						</div>
									<?php wp_nav_menu(
											array(
												'menu' => 'main-menu',
												'container_class' => 'navbar-collapse collapse',
												'menu_class' => 'nav navbar-nav',
												'fallback_cb' => '',
												'menu_id' => 'main-menu',
												'walker' => new wp_bootstrap_navwalker()
											)
										); ?>
					</div>
				</div>
			</div>
		</nav>
	</header>