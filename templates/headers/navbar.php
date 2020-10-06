<?php
/**
 * The template part for Navbar
 *
 * This file is for display the HTML for Bootstrap Navbar.
 * This file is only for tests purpose.
 *
 * @see ItalyStrap\Navbar\Navbar in core/class-navbar.php
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

declare(strict_types=1);

namespace ItalyStrap\Headers;

use ItalyStrap\Components\Navigations\Navbar;
use ItalyStrap\Config\ConfigInterface;
use function ItalyStrap\HTML\close_tag_e;
use function ItalyStrap\HTML\open_tag_e;

/** @var ConfigInterface $config */
$config = $this;

/** @var Navbar $navbar */
$navbar = $config->get('navbar');

//$navbar->output();

//$this->number = self::$instance_count;
//
//$this->navbar_id = apply_filters( 'italystrap_navbar_id', 'italystrap-menu-' . $this->number );
//$this->navbar_id = apply_filters( 'italystrap_navbar_id_' . $this->number, $this->navbar_id );

$number = \esc_attr( $config->get('number', \rand() ) );
$navbar_id = 'italystrap-menu-' . $number;


open_tag_e('nav_container', 'div', [
	'id'	=> 'main-navbar-container-' . $navbar_id,
	'class' => sprintf(
		'navbar-wrapper %s',
		$config->get('mods.navbar.nav_width')
	),
]);

	open_tag_e('navbar_container', 'nav', [
	//        'class'     => 'navbar navbar-expand-lg navbar-light bg-light',
		'class'     => \sprintf(
			'navbar %s %s',
			$config->get('mods.navbar.type'),
			$config->get('mods.navbar.position')
		),
		'role'      => 'navigation',
		'itemscope' => true,
		'itemtype'  => 'https://schema.org/SiteNavigationElement',
	]);

		/**
		 * This was "'last_container'"
		 */
		open_tag_e('nav-inner-container', 'div', [
			'id' => 'menus-container-' . $number,
			'class' => $config->get('mods.navbar.menus_width'),
		]);

			/**
			 * <a class="navbar-brand" href="<?php echo esc_attr( HOME_URL ); ?>">
			 * 	<?php echo esc_attr( GET_BLOGINFO_NAME ) ?>
			 * </a>
			 */
			open_tag_e(
				'navbar_header',
				'div',
				[
					'class' => 'navbar-header',
					'itemprop' => 'publisher',
					'itemscope' => true,
					'itemtype' => 'https://schema.org/Organization',
				]
			);
//			echo $navbar->get_navbar_header();
			echo $navbar->get_navbar_brand();

/**
 *  = BS3 navbar-toggle
 * >= BS4 navbar-toggler
 */
			?>
			<button
				class="navbar-toggler navbar-toggle"
				type="button"
				data-toggle="collapse"
				data-target="#<?php echo $navbar_id ?>"
				aria-controls="<?php echo $navbar_id ?>"
				aria-expanded="false"
				aria-label="Toggle navigation"
			>
<!--				<span class="navbar-toggler-icon">&nbsp</span>-->
				<?php echo apply_filters( 'italystrap_icon_bar', '' ); ?>
			</button>
			<?php


			close_tag_e( 'navbar_header' );

			open_tag_e('collapsable_menu', 'div', [
				'id' => $navbar_id,
				'class' => 'navbar-collapse collapse',
			]);

			/**
			 * Arguments for wp_nav_menu()
			 *
			 * @link https://developer.wordpress.org/reference/functions/wp_nav_menu/
			 * @var array
			 */
			$args = [
				'menu'				=> '',
				'container'			=> false, // WP Default div
				'container_class'	=> false,
				'container_id'		=> false,
				'menu_class'		=> \sprintf(
					'nav navbar-nav %s mr-auto mb-2 mb-lg-0',
					$config->get('mods.navbar.main_menu_x_align')
				),
				'menu_id'			=> 'main-menu',
				'echo'				=> true,
				'fallback_cb'		=> 'Core\Bootstrap_Nav_Menu::fallback',
				'before'			=> '',
				'after'				=> '',
				'link_before'		=> '<span class="item-title" itemprop="name">',
				'link_after'		=> '</span>',
				'items_wrap'		=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
				'depth'				=> 2,
			//					'walker'			=> new Core\Bootstrap_Nav_Menu(),
				'theme_location'	=> 'main-menu',
				'search'			=> false,
			];

			$args = apply_filters( 'italystrap_main_nav_menu_args', $args );

			echo $navbar->get_wp_nav_menu($args);
			//			wp_nav_menu( $args );

			if ( has_nav_menu( 'secondary-menu' ) ) :

				/**
				 * Arguments for wp_nav_menu()
				 *
				 * @link https://developer.wordpress.org/reference/functions/wp_nav_menu/
				 * @var array
				 */
				$args = [
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
			//						'walker'			=> new Core\Bootstrap_Nav_Menu(),
					'theme_location'	=> 'secondary-menu',
					'search'			=> false,
				];

				$args = apply_filters( 'italystrap_secondary_nav_menu_args', $args );

				wp_nav_menu( $args );
			endif;

			close_tag_e('collapsable_menu');
			close_tag_e('nav-inner-container');
			close_tag_e('navbar_container');

			close_tag_e('nav_container');
