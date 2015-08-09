<?php
/**
 * The Header for Italystrap
 *
 * Displays all of the <head> section and Main menu
 *
 * For improve performance replace $lang_attr with lang="xx-XX" when xx_XX is your language (en_EN - de_DE - fr_FR - ecc)
 * Otherwise you can use <?php language_attributes(); ?> instead 
 *
 * You can also replace <?php bloginfo( 'charset' ); ?> with "UTF-8" or your charset
 * @since ItalyStrap 1.0
 */
?>
<!DOCTYPE html>
<!--[if lt IE 7]>		<html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?> prefix="og: http://ogp.me/ns#"> <![endif]-->
<!--[if IE 7]>			<html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?> prefix="og: http://ogp.me/ns#"> <![endif]-->
<!--[if IE 8]>			<html class="no-js lt-ie9" <?php language_attributes(); ?> prefix="og: http://ogp.me/ns#"> <![endif]-->
<!--[if gt IE 8]><!-->	<html class="no-js" <?php language_attributes(); ?> prefix="og: http://ogp.me/ns#"> <!--<![endif]-->
<head>
	<meta charset="UTF-8" >
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head();?>
</head>
<body <?php body_class(); ?>>
	<?php do_action( 'body_open' ); ?>
<div class="wrapper">
	<?php do_action( 'wrapper_open' );

	/**
	 * Get the header image url if is set
	 * @var string
	 */
	$get_header_image = get_header_image();
	/**
	 * If header image is set then load header
	 */
	if ( $get_header_image ): ?>
	<header class="header-wrapper">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<?php
					
					$custom_header = '<img src="' . $get_header_image . '" class="img-responsive center-block" height="' . get_custom_header()->height . '" width="' . get_custom_header()->width . '" alt="' . esc_attr( GET_BLOGINFO_NAME ) . '"/>';
					
					if ( function_exists( 'italystrap_apply_lazyload' ) )
						echo italystrap_apply_lazyload( $custom_header );
					else
						echo $custom_header;
					
					?>
				</div>
			</div>
		</div>
	</header>
	<?php endif;
	/**
	 * This is only a nav container
	 * .navbar-wrapper style is in _menu.scss css/src/sass
	 */
	if ( has_nav_menu( 'main-menu' ) ) :
	?>
	<nav class="container navbar-wrapper" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
		<?php
		do_action( 'nav_open' );
		/**
		 * Modify style for menù with bootstrap style
		 * @link http://getbootstrap.com/components/#navbar
		 */
		?>
		<div class="navbar navbar-inverse navbar-relative-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only"><?php _e( 'Toggle navigation', 'ItalyStrap' ); ?></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<span itemprop="publisher" itemscope itemtype="http://schema.org/Organization">
						<a class="navbar-brand" href="<?php echo esc_attr( HOME_URL ); ?>" title="<?php echo esc_attr( GET_BLOGINFO_NAME ) . ' &dash; ' . esc_attr( GET_BLOGINFO_DESCRIPTION ); ?>" rel="home" itemprop="url"><span itemprop="name"><?php echo esc_attr( GET_BLOGINFO_NAME ); ?></span></a>
						<meta  itemprop="image" content="<?php echo italystrap_logo();?>"/>
					</span>
				</div>
				<?php
				do_action( 'before_wp_nav_menu' );
				wp_nav_menu(
					array(
						'theme_location'	=> 'main-menu',
						'depth'				=>	2,
						'container'         => 'div',
						'container_class'	=> 'navbar-collapse collapse',
						'menu_class'		=> 'nav navbar-nav',
						'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
						'menu_id'			=> 'main-menu',
						'walker'			=> new wp_bootstrap_navwalker(),
						// 'search'			=> false
					)
				);
				do_action( 'after_wp_nav_menu' );
				?>
			</div>
		</div>
		<?php do_action( 'nav_closed' ); ?>
	</nav>
	<?php endif; ?>