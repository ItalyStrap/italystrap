<!DOCTYPE html>
<!--[if lt IE 7]>		<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>			<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>			<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->	<html class="no-js"> <!--<![endif]-->
<html lang="it" xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:og="http://opengraphprotocol.org/schema/">
<head>
	<meta charset="UTF-8" >
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php wp_title('|', true, 'right'); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
<?php get_template_part( 'lib/facebook_opengraph' ); ?>

<?php wp_head();?>
</head>
<body>
    <header>
		<nav  class="navbar-wrapper">
			<div class="container" itemscope itemtype="http://schema.org/SiteNavigationElement">
				<div class="navbar navbar-inverse navbar-relative-top">
					<div class="navbar-inner">
							<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</a>
							<span itemprop="publisher" itemscope itemtype="http://schema.org/Organization">
								<a class="brand" href="<?php echo home_url('/'); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home" itemprop="url"><span itemprop="name"><?php bloginfo('name'); ?></span></a>
								<meta  itemprop="image" content="<?php echo italystrap_logo();?>"/>
							</span>
									<?php wp_nav_menu(
											array(
												'menu' => 'main-menu',
												'container_class' => 'nav-collapse collapse',
												'menu_class' => 'nav',
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