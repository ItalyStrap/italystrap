<?php
/**
 * The template part for Navbar
 *
 * This file is for display the HTML for Bootstrap Navbar.
 * This file is only for tests purpose.
 *
 * @see ItalyStrap\Core\Navbar\Navbar in core/class-navbar.php
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Headers;

?>
<nav class="container navbar-wrapper" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement">
	<?php
	do_action( 'nav_open' );
	/**
	 * Modify style for menù with bootstrap style
	 *
	 * @link http://getbootstrap.com/components/#navbar
	 */
	?>
	<div class="navbar navbar-inverse navbar-relative-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
					<span class="sr-only"><?php esc_attr_e( 'Toggle navigation', 'italystrap' ); ?></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<?php if ( $logo_url = false ) : ?>
					<a class="navbar-brand" href="<?php echo esc_attr( HOME_URL ); ?>">
						<img alt="<?php echo esc_attr( GET_BLOGINFO_NAME ) . ' &dash; ' . esc_attr( GET_BLOGINFO_DESCRIPTION ); ?>" src="<?php echo esc_html( $logo_url ); ?>" width="214px" height="45px" class="img-responsive">
					</a>
				<?php else : ?>
					<span itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
						<a class="navbar-brand" href="<?php echo esc_attr( HOME_URL ); ?>" title="<?php echo esc_attr( GET_BLOGINFO_NAME ) . ' &dash; ' . esc_attr( GET_BLOGINFO_DESCRIPTION ); ?>" rel="home" itemprop="url"><span itemprop="name"><?php echo esc_attr( GET_BLOGINFO_NAME ); ?></span></a>
						<meta  itemprop="image" content="<?php echo italystrap_logo();?>"/>
					</span>
				<?php endif; ?>
			</div>
			<?php do_action( 'italystrap_before_wp_nav_menu' ); ?>
			<div id="navbar-collapse" class="navbar-collapse collapse">
				<?php
				/**
				 * Arguments for wp_nav_menu()
				 *
				 * @link https://developer.wordpress.org/reference/functions/wp_nav_menu/
				 * @var array
				 */
				$args = array(
					'menu'				=> '',
					'container'			=> false, // WP Default div
					'container_class'	=> false,
					'container_id'		=> false,
					'menu_class'		=> 'nav navbar-nav',
					'menu_id'			=> 'main-menu',
					'echo'				=> true,
					'fallback_cb'		=> 'Core\Bootstrap_Nav_Menu::fallback',
					'before'			=> '',
					'after'				=> '',
					'link_before'		=> '<span class="item-title" itemprop="name">',
					'link_after'		=> '</span>',
					'items_wrap'		=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
					'depth'				=> 2,
					'walker'			=> new Core\Bootstrap_Nav_Menu(),
					'theme_location'	=> 'main-menu',
					'search'			=> false,
				);

				$args = apply_filters( 'italystrap_main_nav_menu_args', $args );

				wp_nav_menu( $args );

				if ( has_nav_menu( 'secondary-menu' ) ) :

					/**
					 * Arguments for wp_nav_menu()
					 *
					 * @link https://developer.wordpress.org/reference/functions/wp_nav_menu/
					 * @var array
					 */
					$args = array(
						'menu'				=> '',
						'container'			=> false, // WP Default div
						'container_class'	=> false,
						'container_id'		=> false,
						'menu_class'		=> 'nav navbar-nav navbar-right',
						'menu_id'			=> 'secondary-menu',
						'echo'				=> true,
						'fallback_cb'		=> false,
						'before'			=> '',
						'after'				=> '',
						'link_before'		=> '<span class="item-title" itemprop="name">',
						'link_after'		=> '</span>',
						'items_wrap'		=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'depth'				=> 2,
						'walker'			=> new Core\Bootstrap_Nav_Menu(),
						'theme_location'	=> 'secondary-menu',
						'search'			=> false,
					);

					$args = apply_filters( 'italystrap_secondary_nav_menu_args', $args );

					wp_nav_menu( $args );

				endif;
				?>
			</div>
			<?php do_action( 'italystrap_after_wp_nav_menu' ); ?>
		</div>
	</div>
	<?php do_action( 'nav_closed' ); ?>
</nav>
<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
		<a class="navbar-brand" href="#">Hidden brand</a>
		<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
			<li class="nav-item active">
				<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Link</a>
			</li>
			<li class="nav-item">
				<a class="nav-link disabled" href="#">Disabled</a>
			</li>
		</ul>
		<form class="form-inline my-2 my-lg-0">
			<input class="form-control mr-sm-2" type="text" placeholder="Search">
			<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
		</form>
	</div>
</nav>