<?php namespace ItalyStrap\Core;
/**
 * Navbar Menu template Class
 *
 * @package ItalyStrap\Core
 * @since 4.0.0
 */

/**
 * Template for Navbar like Botstrap CSS 
 */
class Navbar {

	/**
	 * Count the number of instance
	 *
	 * @var integer
	 */
	private static $instanceCount = 0;

	/**
	 * The ID of the Navbar instance
	 *
	 * @var string
	 */
	private $navbar_id;

	/**
	 * Init the constructor
	 */
	public function __construct() {

		self::$instanceCount++;

		$this->navbar_id = apply_filters( 'italystrap_navbar_id', 'menu-' . self::$instanceCount );
	}

	public function get_html_tag_attr( $attr = array() ) {

		$html = '';

		/**
		 * Filter the list of attachment image attributes.
		 *
		 * @since 2.8.0
		 *
		 * @param array        $attr       Attributes for the image markup.
		 * @param WP_Post      $attachment Image attachment post.
		 * @param string|array $size       Requested size. Image size or array of width and height values
		 *                                 (in that order). Default 'thumbnail'.
		 */
		// $attr = apply_filters( 'wp_get_attachment_image_attributes', $attr );
		$attr = array_map( 'esc_attr', $attr );
		// $html = rtrim("<img $hwstring");
		foreach ( $attr as $name => $value ) {
			$html .= " $name=" . '"' . $value . '"';
		}
		// $html .= ' />';
		
		return $html;

	}

	public function get_wp_nav_menu( $args = array() ) {

		/**
		 * Arguments for wp_nav_menu()
		 *
		 * @link https://developer.wordpress.org/reference/functions/wp_nav_menu/
		 * @var array
		 */
		$defaults = array(
			'menu'				=> '',
			'container'			=> false, // WP Default div
			'container_class'	=> false,
			'container_id'		=> false,
			'menu_class'		=> 'nav navbar-nav',
			'menu_id'			=> 'main-menu',
			'echo'				=> false,
			'fallback_cb'		=> 'Bootstrap_Nav_Menu::fallback',
			'before'			=> '',
			'after'				=> '',
			'link_before'		=> '<span class="item-title" itemprop="name">',
			'link_after'		=> '</span>',
			'items_wrap'		=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth'				=> 2,
			'walker'			=> new Bootstrap_Nav_Menu(),
			'theme_location'	=> 'main-menu',
			'search'			=> false,
		);

		$args = wp_parse_args( $args, $defaults );

		$args = apply_filters( 'italystrap_' . $args['theme_location'] . '_args', $args, $this->navbar_id );

		return wp_nav_menu( $args );

	}

	public function get_navbar_header() {

		$a = array(
			'class'			=> 'navbar-header',
			'itemprop'		=> 'publisher',
			'itemscope'		=> '',
			'itemtype'		=> 'http://schema.org/Organization',
		);

		$a = apply_filters( 'italystrap_navbar_header_attr', $a, $this->navbar_id );

		$output = '';

		$output .= '<div' . $this->get_html_tag_attr( $a ) . '>';
		$output .= $this->get_toggle_button();
		$output .= $this->get_navbar_brand();
		$output .= '</div>';

		return apply_filters( 'italystrap_navbar_header', $output, $this->navbar_id );

	}

	public function get_toggle_button() {

		$output = '';

		$a = array(
			'type'			=> 'button',
			'class'			=> 'navbar-toggle',
			'data-toggle'	=> 'collapse',
			'data-target'	=> '#' . $this->navbar_id,
		);

		$a = apply_filters( 'italystrap_toggle_button_attr', $a, $this->navbar_id );

		$output .= '<button';
		$output .= $this->get_html_tag_attr( $a ) . '>';
		$output .= '<span class="sr-only">' . esc_attr__( 'Toggle navigation', 'ItalyStrap' ) . '</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>';

		return apply_filters( 'italystrap_toggle_button', $output, $this->navbar_id );
	}

	public function get_navbar_brand() {

		$output = '';

		$a = array(
			'class'			=> 'navbar-brand',
			'href'			=> esc_attr( HOME_URL ),
			'title'			=> esc_attr( GET_BLOGINFO_NAME ) . ' - ' . esc_attr( GET_BLOGINFO_DESCRIPTION ),
			'rel'			=> 'home',
			'itemprop'		=> 'url',
		);

		$a = apply_filters( 'italystrap_navbar_brand_attr', $a, $this->navbar_id );

		$output .= '<a' . $this->get_html_tag_attr( $a ) . '>';

		if ( $attachment_id = false ) {

			$attr = array(
				'class'			=> 'img-responsive center-block',
				'alt'			=> esc_attr( GET_BLOGINFO_NAME ) . ' &dash; ' . esc_attr( GET_BLOGINFO_DESCRIPTION ),
				'itemprop'		=> 'image',
			);

			$output .= wp_get_attachment_image( $attachment_id, 'navbar-brand-image', false, $attr );

			$output .= '<meta  itemprop="name" content="' . esc_attr( GET_BLOGINFO_NAME ) . '"/>';

		} else {

			$output .= '<span itemprop="name">' . esc_attr( GET_BLOGINFO_NAME ) . '</span><meta  itemprop="image" content="' . \italystrap_get_the_custom_image_url( 'logo', ITALYSTRAP_PARENT_PATH . '/img/italystrap-logo.jpg' ) . '"/>';

		}

		$output .= '</a>';
		
		return apply_filters( 'italystrap_navbar_brand', $output, $this->navbar_id );

	}

	public function get_collapsable_menu() {

		$a = array(
			'id'			=> $this->navbar_id,
			'class'			=> 'navbar-collapse collapse',
		);

		$a = apply_filters( 'italystrap_collapsable_menu_attr', $a, $this->navbar_id );

		$output = '';

		$output .= '<div' . $this->get_html_tag_attr( $a ) . '>';
		$output .= $this->get_wp_nav_menu();

		if ( has_nav_menu( 'secondary-menu' ) ) :

			$args = array(
				'menu_class'		=> 'nav navbar-nav navbar-right',
				'menu_id'			=> 'secondary-menu',
				'fallback_cb'		=> false,
				'theme_location'	=> 'secondary-menu',
			);

			$output .= $this->get_wp_nav_menu( $args );

		endif;

		$output .= '</div>';

		return apply_filters( 'italystrap_collapsable_menu', $output, $this->navbar_id );
	}

	public function output() {

		/**
		 * This is only a nav container
		 * .navbar-wrapper style is in _menu.scss css/src/sass
		 */
		?>
		<nav class="container navbar-wrapper" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
			<?php
			/**
			 * Modify style for menù with bootstrap style
			 *
			 * @link http://getbootstrap.com/components/#navbar
			 */
			?>
			<div class="navbar navbar-inverse navbar-relative-top">
				<div class="container-fluid">
					<?php echo $this->get_navbar_header(); ?>
					<?php echo $this->get_collapsable_menu(); ?>
				</div>
			</div>
		</nav>
		<?php

	}

}
