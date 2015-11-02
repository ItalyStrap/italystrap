<?php namespace ItalyStrap;
/**
 * The template part for header.php
 * This file is for display the HTML tags header and nav
 */
use \ItalyStrap\Core;
use \ItalyStrap\Core\ItalyStrap_Navwalker;
use \wp_bootstrap_navwalker;
/**
 * Get the header image url if is set
 * @var string
 */
// $get_header_image = get_header_image();
/**
 * Get the header pbject
 * @var object
 */
$get_header_image = get_custom_header();

/**
 * If header image is set then load header
 */
if ( $get_header_image->url ) :?>
	<header class="header-wrapper">
		<?php do_action( 'header_open' ); ?>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<?php
					$custom_header = '<img src="' . $get_header_image->url . '" class="img-responsive center-block" height="' . $get_header_image->height . '" width="' . $get_header_image->width . '" alt="' . esc_attr( GET_BLOGINFO_NAME ) . '"/>';

					if ( function_exists( 'italystrap_apply_lazyload' ) )
						echo italystrap_apply_lazyload( $custom_header );
					else echo $custom_header;

					?>
				</div>
			</div>
		</div>
		<?php do_action( 'header_closed' ); ?>
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
					<span class="sr-only"><?php esc_attr_e( 'Toggle navigation', 'ItalyStrap' ); ?></span>
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
					'depth'				=> 2,
					'container'         => 'div',
					'container_class'	=> 'navbar-collapse collapse',
					'menu_class'		=> 'nav navbar-nav',
					'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
					'menu_id'			=> 'main-menu',
					'walker'			=> new wp_bootstrap_navwalker(),
					'search'			=> false,
				)
			);
			do_action( 'after_wp_nav_menu' );
			?>
		</div>
	</div>
	<?php do_action( 'nav_closed' ); ?>
</nav>
<?php endif;
