<?php namespace ItalyStrap\Core;
/**
 * Navbar Menu template Class
 *
 * @example http://www.bootply.com/mQh8DyRfWY bootstrap navbar center logo
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
	private static $instance_count = 0;

	/**
	 * The number of this instance
	 *
	 * @var integer
	 */
	private $number;

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

		self::$instance_count++;

		$this->number = self::$instance_count;

		$this->navbar_id = apply_filters( 'italystrap_navbar_id', 'italystrap-menu-' . $this->number );
	}

	/**
	 * Render the HTML tag attributes from an array
	 *
	 * @param  array $attr The HTML attributes with key value.
	 * @return string      Return a string with HTML attributes
	 */
	public function get_html_tag_attr( $attr = array() ) {

		$html = '';

		$attr = array_map( 'esc_attr', $attr );
		foreach ( $attr as $name => $value ) {
			$html .= " $name=" . '"' . $value . '"';
		}

		return $html;

	}

	/**
	 * Get the wp_nav_menu with default parameters for Bootstrap CSS style
	 *
	 * @param  array $args The wp_nav_menu arguments.
	 * @return string      Return the wp_nav_menu HTML
	 */
	public function get_wp_nav_menu( $args = array() ) {

		/**
		 * Arguments for wp_nav_menu()
		 * For filtering wp_nav_menu use the 'wp_nav_menu' hooks with 2 parameters
		 * add_filter( 'wp_nav_menu', 'your_functions', 10, 2 );
		 * For this situation the container attribute is set to false because
		 * we need the collapsable functionality of Bootstrap CSS.
		 *
		 * @link https://developer.wordpress.org/reference/functions/wp_nav_menu/
		 * @var array
		 */
		$defaults = array(
			'menu'				=> '',
			'container'			=> false, // WP Default div.
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

	/**
	 * Get the HTML for Navbar Header
	 *
	 * @return string Return the HTML for Navbar Header
	 */
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

	/**
	 * Get the HTML for toggle button
	 *
	 * @return string Return the HTML for toggle button
	 */
	public function get_toggle_button() {

		$icon_bar = apply_filters( 'italystrap_icon_bar', '<span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>' );

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
		$output .= '<span class="sr-only">' . esc_attr__( 'Toggle navigation', 'ItalyStrap' ) . '</span>' . $icon_bar . '</button>';

		return apply_filters( 'italystrap_toggle_button', $output, $this->navbar_id );
	}

	/**
	 * Get the HTML for description
	 *
	 * @return string Return the HTML for description
	 */
	public function get_navbar_brand() {

		/**
		 * Theme options
		 *
		 * @todo Da mettere a posto.
		 * @var array
		 */
		$theme_mods = get_theme_mods();
// var_dump($theme_mods);
		/**
		 * The ID of the logo image for navbar
		 * By default in the customizer is set a url for the image instead an integer
		 * When it is choices an image than it will set an integer for $theme_mods['navbar_logo']
		 * @var integer
		 */
		$attachment_id = absint( isset( $theme_mods['navbar_logo_image'] ) ? $theme_mods['navbar_logo_image'] : null );

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

		if ( $attachment_id && empty( $theme_mods['display_navbar_logo_image'] ) ) {

			$attr = array(
				'class'			=> 'img-brand img-responsive center-block',
				'alt'			=> esc_attr( GET_BLOGINFO_NAME ) . ' &dash; ' . esc_attr( GET_BLOGINFO_DESCRIPTION ),
				'itemprop'		=> 'image',
			);

			$output .= wp_get_attachment_image( $attachment_id, 'navbar-brand-image', false, $attr );

			$output .= '<meta  itemprop="name" content="' . esc_attr( GET_BLOGINFO_NAME ) . '"/>';

		} elseif ( $attachment_id && ! empty( $theme_mods['display_navbar_logo_image'] ) ) {

			$attr = array(
				'class'			=> 'img-brand',
				'alt'			=> esc_attr( GET_BLOGINFO_NAME ) . ' &dash; ' . esc_attr( GET_BLOGINFO_DESCRIPTION ),
				'itemprop'		=> 'image',
				'style'			=> 'display:inline;margin-right:15px;',
			);

			$output .= wp_get_attachment_image( $attachment_id, 'navbar-brand-image', false, $attr );

			$output .= '<span class="brand-name" itemprop="name">' . esc_attr( GET_BLOGINFO_NAME ) . '</span>';

		} else {

			$output .= '<span class="brand-name" itemprop="name">' . esc_attr( GET_BLOGINFO_NAME ) . '</span><meta  itemprop="image" content="' . \italystrap_get_the_custom_image_url( 'logo', ITALYSTRAP_PARENT_PATH . '/img/italystrap-logo.jpg' ) . '"/>';

		}

		$output .= '</a>';

		return apply_filters( 'italystrap_navbar_brand', $output, $this->navbar_id );

	}

	/**
	 * Get the collapsable HTML menu
	 *
	 * @return string Return the HTML
	 */
	public function get_collapsable_menu() {

		$a = array(
			'id'			=> $this->navbar_id,
			'class'			=> 'navbar-collapse collapse',
		);

		$a = apply_filters( 'italystrap_collapsable_menu_attr', $a, $this->navbar_id );

		$output = '';

		$output .= '<div' . $this->get_html_tag_attr( $a ) . '>';
		$output .= $this->get_wp_nav_menu();

		/**
		 * http://bootsnipp.com/snippets/featured/expanding-search-button-in-css
		 */
		if ( false ) {
			$output .= get_search_form();
		}

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

	public function get_last_container() {

		$a = array(
			'class'			=> 'container-fluid',
		);

		$a = apply_filters( 'italystrap_last_container_attr', $a, $this->navbar_id );

		$output = '';

		$output .= '<div' . $this->get_html_tag_attr( $a ) . '>';

		$output .= $this->get_navbar_header();
		$output .= $this->get_collapsable_menu();

		$output .= '</div>';

		return apply_filters( 'italystrap_last_container', $output, $this->navbar_id );

	}

	public function get_navbar_container() {

		$a = array(
			'class'			=> 'navbar navbar-inverse navbar-relative-top',
		);

		$a = apply_filters( 'italystrap_navbar_container_attr', $a, $this->navbar_id );

		$output = '';

		$output .= '<div' . $this->get_html_tag_attr( $a ) . '>';

		$output .= $this->get_last_container();

		$output .= '</div>';

		return apply_filters( 'italystrap_navbar_container', $output, $this->navbar_id );

	}

	public function get_nav_container() {

		$a = array(
			'class'			=> 'container navbar-wrapper',
			'role'			=> 'navigation',
			'itemscope'		=> '',
			'itemtype'		=> 'http://schema.org/SiteNavigationElement',
		);

		$a = apply_filters( 'italystrap_nav_container_attr', $a, $this->navbar_id );

		$output = '';

		$output .= '<div' . $this->get_html_tag_attr( $a ) . '>';

		$output .= $this->get_navbar_container();

		$output .= '</div>';

		return apply_filters( 'italystrap_nav_container', $output, $this->navbar_id );

	}

	/**
	 * Output the HTML
	 */
	public function output() {

		echo $this->get_nav_container();

	}
}
