<?php
/**
 * Navbar Menu template Class
 *
 * @example http://www.bootply.com/mQh8DyRfWY bootstrap navbar center logo
 *
 * @package ItalyStrap\Core
 * @since 4.0.0
 */

namespace ItalyStrap\Navbar;

use ItalyStrap\Core;
use Walker_Nav_Menu;

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
	 * Array with theme options
	 *
	 * @var array
	 */
	private $theme_mods = array();

	/**
	 * The ID of the Navbar instance
	 *
	 * @var string
	 */
	private $navbar_id;

	/**
	 * Walker instance
	 *
	 * @var Walker_Nav_Menu
	 */
	protected $walker = null;

	/**
	 * Init the constructor
	 */
	public function __construct( array $theme_mods = array(), Walker_Nav_Menu $walker ) {

		$this->walker = $walker;

		self::$instance_count++;

		$this->number = self::$instance_count;

		$this->navbar_id = apply_filters( 'italystrap_navbar_id', 'italystrap-menu-' . $this->number );

		$this->theme_mods = $theme_mods;
	}

	/**
	 * Render the HTML tag attributes from an array
	 *
	 * @param  array $attr The HTML attributes with key value.
	 * @return string      Return a string with HTML attributes
	 */
	public function get_html_tag_attr( $attr = array(), $context = '' ) {

		return Core\get_attr( $context, $attr, false, $this->navbar_id );
	}

	/**
	 * Get the wp_nav_menu with default parameters for Bootstrap CSS style
	 *
	 * @param  array $args The wp_nav_menu arguments.
	 *
	 * @return string      Return the wp_nav_menu HTML
	 */
	public function get_wp_nav_menu( array $args = array() ) {

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
			'depth'				=> 10,
			'walker'			=> $this->walker,
			'theme_location'	=> 'main-menu',
			'search'			=> false,
		);

		// $defaults['fallback_cb'] = $this->walker->fallback( $defaults );

		$args = wp_parse_args( $args, $defaults );

		$args = apply_filters( 'italystrap_' . $args['theme_location'] . '_args', $args, $this->navbar_id );

		return wp_nav_menu( $args );

	}

	/**
	 * Get secondary wp-nav-menu
	 *
	 * @return string      Return the secondary wp_nav_menu HTML
	 */
	public function get_secondary_wp_nav_menu() {

		if ( ! has_nav_menu( 'secondary-menu' ) ) {
			return '';
		}

		$args = array(
			'menu_class'		=> 'nav navbar-nav navbar-right',
			'menu_id'			=> 'secondary-menu',
			'fallback_cb'		=> false,
			'theme_location'	=> 'secondary-menu',
		);

		return $this->get_wp_nav_menu( $args );
	
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
			'itemscope'		=> true,
			'itemtype'		=> 'https://schema.org/Organization',
		);

		$output = sprintf(
			'<div %s>%s%s</div>',
			$this->get_html_tag_attr( $a, 'navbar_header' ),
			$this->get_toggle_button(),
			$this->get_navbar_brand()
		);

		return apply_filters( 'italystrap_navbar_header', $output, $this->navbar_id );

	}

	/**
	 * Get the HTML for toggle button
	 *
	 * @return string Return the HTML for toggle button
	 */
	public function get_toggle_button() {

		$icon_bar = apply_filters( 'italystrap_icon_bar', '<span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>' );

		$a = array(
			// 'type'			=> 'button',
			'class'			=> 'navbar-toggle',
			'data-toggle'	=> 'collapse',
			'data-target'	=> '#' . $this->navbar_id,
		);

		$output = sprintf(
			'<button %s><span class="sr-only">%s</span>%s</button>',
			$this->get_html_tag_attr( $a, 'toggle_button' ),
			esc_attr__( 'Toggle navigation', 'italystrap' ),
			$icon_bar
		);

		return apply_filters( 'italystrap_toggle_button', $output, $this->navbar_id );
	}

	/**
	 * Get Brand
	 *
	 * @return string Return the HTML for brand name and/or image.
	 */
	public function get_brand() {
	
		/**
		 * The ID of the logo image for navbar
		 * By default in the customizer is set a url for the image instead of an integer
		 * When it is choices an image than it will set an integer for $this->theme_mods['navbar_logo']
		 *
		 * @var integer
		 */
		$attachment_id = isset( $this->theme_mods['navbar_logo_image'] ) ? absint( $this->theme_mods['navbar_logo_image'] ) : null;

		$attachment_id = apply_filters( 'italystrap_navbar_logo_image_id', $attachment_id );

		$brand = '';

		if ( $attachment_id && 'display_image' === $this->theme_mods['display_navbar_brand'] ) {

			$attr = array(
				'class'			=> 'img-brand img-responsive center-block',
				'alt'			=> esc_attr( GET_BLOGINFO_NAME ) . ' &dash; ' . esc_attr( GET_BLOGINFO_DESCRIPTION ),
				'itemprop'		=> 'image',
			);

			/**
			 * Size default: navbar-brand-image
			 */
			$brand .= wp_get_attachment_image( $attachment_id, $this->theme_mods['navbar_logo_image_size'], false, $attr );

			$brand .= '<meta  itemprop="name" content="' . esc_attr( GET_BLOGINFO_NAME ) . '"/>';

		} elseif ( $attachment_id && 'display_all' === $this->theme_mods['display_navbar_brand'] ) {

			$attr = array(
				'class'			=> 'img-brand img-responsive center-block',
				'alt'			=> esc_attr( GET_BLOGINFO_NAME ) . ' &dash; ' . esc_attr( GET_BLOGINFO_DESCRIPTION ),
				'itemprop'		=> 'image',
				'style'			=> 'display:inline;margin-right:15px;',
			);
			/**
			 * Size default: navbar-brand-image
			 */
			$brand .= wp_get_attachment_image( $attachment_id, $this->theme_mods['navbar_logo_image_size'], false, $attr );

			$brand .= '<span class="brand-name" itemprop="name">' . esc_attr( GET_BLOGINFO_NAME ) . '</span>';

		} else {

			$brand .= '<span class="brand-name" itemprop="name">' . esc_attr( GET_BLOGINFO_NAME ) . '</span><meta  itemprop="image" content="' . \italystrap_get_the_custom_image_url( 'logo', TEMPLATEURL . '/img/italystrap-logo.jpg' ) . '"/>';

		}

		return $brand;
	}

	/**
	 * Get the HTML for description
	 *
	 * @param  array  $attr The navbar brand attributes.
	 *
	 * @return string       Return the HTML for description
	 */
	public function get_navbar_brand( array $attr = array() ) {

		if ( 'none' === $this->theme_mods['display_navbar_brand'] ) {
			return apply_filters( 'italystrap_navbar_brand_none', '', $this->navbar_id );
		}

		$default = array(
			'class'			=> 'navbar-brand',
			'href'			=> esc_attr( HOME_URL ),
			'title'			=> esc_attr( GET_BLOGINFO_NAME ) . ' - ' . esc_attr( GET_BLOGINFO_DESCRIPTION ),
			'rel'			=> 'home',
			'itemprop'		=> 'url',
		);

		$output = sprintf(
			'<a %s>%s</a>',
			$this->get_html_tag_attr( array_merge( $default, $attr ), 'navbar_brand' ),
			$this->get_brand()
		);

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

		/**
		 * http://bootsnipp.com/snippets/featured/expanding-search-button-in-css
		 */
		// if ( false ) {
		// 	$output .= get_search_form();
		// }

		$output = sprintf(
			'<div %s>%s%s</div>',
			$this->get_html_tag_attr( $a, 'collapsable_menu' ),
			$this->get_wp_nav_menu(),
			$this->get_secondary_wp_nav_menu()
		);

		return apply_filters( 'italystrap_collapsable_menu', $output, $this->navbar_id );
	}

	/**
	 * A container inside the navbar-default/revers
	 *
	 * @return string The html output.
	 */
	public function get_last_container() {

		$a = array(
			'id'			=> 'menus-container-' . $this->number,
			'class'			=> esc_attr( $this->theme_mods['navbar']['menus_width'] ),
		);

		$output = sprintf(
			'<div %s>%s%s</div>',
			$this->get_html_tag_attr( $a, 'last_container' ),
			$this->get_navbar_header(),
			$this->get_collapsable_menu()
		);

		return apply_filters( 'italystrap_last_container', $output, $this->navbar_id );

	}

	/**
	 * The regulare navbar container,
	 * this manage the type of navabr available from Twitter Bootstrap
	 *
	 * @see http://getbootstrap.com/components/#navbar
	 *
	 * navbar-default
	 * navbar-inverse
	 *
	 * navbar navbar-default navbar-relative-top
	 *
	 * navbar navbar-default navbar-fixed-top // body { padding-top: 70px; }
	 * navbar navbar-default navbar-fixed-bottom // body { padding-bottom: 70px; }
	 *
	 * navbar navbar-default navbar-static-top
	 *
	 * @return string The navbar string.
	 */
	public function get_navbar_container() {

		$a = array(
			'class'			=> sprintf(
				'navbar %s %s',
				esc_attr( $this->theme_mods['navbar']['type'] ),
				esc_attr( $this->theme_mods['navbar']['position'] )
			),
		);

		$output = sprintf(
			'<div %s>%s</div>',
			$this->get_html_tag_attr( $a, 'navbar_container' ),
			$this->get_last_container()
		);

		return apply_filters( 'italystrap_navbar_container', $output, $this->navbar_id );

	}

	/**
	 * Generate the nav tag container of entire navbar
	 *
	 * @see http://getbootstrap.com/components/#navbar
	 *
	 * This manage the full width or boxed width (.conainer or null)
	 *
	 * @return string Return the entire navbar.
	 */
	public function get_nav_container() {

		$a = array(
			'class'			=> sprintf(
				'navbar-wrapper %s',
				esc_attr( $this->theme_mods['navbar']['nav_width'] )
			),
			'itemscope'		=> true,
			'itemtype'		=> 'https://schema.org/SiteNavigationElement',
		);

		$output = sprintf(
			'<nav %s>%s</nav>',
			$this->get_html_tag_attr( $a, 'nav_container' ),
			$this->get_navbar_container()
		);

		return apply_filters( 'italystrap_nav_container', $output, $this->navbar_id );

	}

	/**
	 * Output the HTML
	 */
	public function output() {

		echo $this->get_nav_container();

	}
}
