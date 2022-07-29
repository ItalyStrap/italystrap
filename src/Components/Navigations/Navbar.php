<?php
declare(strict_types=1);

namespace ItalyStrap\Components\Navigations;

use ItalyStrap\Components\Brand\Brand;
use \ItalyStrap\Config\ConfigInterface;
use function \ItalyStrap\HTML\get_attr;
use \Walker_Nav_Menu;

/**
 * Template for Navbar like Botstrap CSS
 * @example http://www.bootply.com/mQh8DyRfWY bootstrap navbar center logo
 * @deprecated
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
	 * Config instance
	 *
	 * @var ConfigInterface
	 */
	private $config;

	/**
	 * Walker instance
	 *
	 * @var Walker_Nav_Menu
	 */
	private $walker;

	/**
	 * @var bool|callable   $fallback_cb If the menu doesn't exists, a callback function will fire.
	 * 						Default is 'wp_page_menu'. Set to false for no fallback.
	 */
	private $fallback_cb;
	/**
	 * @var Brand
	 */
	private $brand;

	/**
	 * Init the constructor
	 *
	 * @param ConfigInterface $config
	 * @param Walker_Nav_Menu $walker
	 * @param callable|bool $fallback_cb If the menu doesn't exists, a callback function will fire.
	 *                                        Default is 'wp_page_menu'. Set to false for no fallback.
	 * @param Brand $brand
	 */
	public function __construct(
		ConfigInterface $config,
		Walker_Nav_Menu $walker,
		Brand $brand,
		$fallback_cb = false
	) {

		$this->config = $config;
		$this->walker = $walker;
		$this->fallback_cb = $fallback_cb;

		/**
		 * Count this instance
		 */
		self::$instance_count ++;

		$this->number = self::$instance_count;

		$this->navbar_id = apply_filters( 'italystrap_navbar_id', 'italystrap-menu-' . $this->number );
		$this->navbar_id = apply_filters( 'italystrap_navbar_id_' . $this->number, $this->navbar_id );

		$this->brand = $brand;
	}

	/**
	 * Get the wp_nav_menu with default parameters for Bootstrap CSS style
	 *
	 * @param array $args The wp_nav_menu arguments.
	 *
	 * @return false|null|string Return the wp_nav_menu HTML
	 */
	public function get_wp_nav_menu( array $args = [] ) {// phpcs:ignore

		/**
		 * Arguments for wp_nav_menu()
		 * For filtering wp_nav_menu use the 'wp_nav_menu' hooks with 2 parameters
		 * add_filter( 'wp_nav_menu', 'your_functions', 10, 2 );
		 * For this situation the container attribute is set to false because
		 * we need the collapsable functionality of Bootstrap CSS.
		 *
		 * @todo  Non credo mi possa essere utile https://github.com/devaloka/nav-menu ma si
		 * 		potrebbe comunque creare una classe a parte per wp_nav_menu e togliere da qui.
		 *
		 * @link https://developer.wordpress.org/reference/functions/wp_nav_menu/
		 * @var array
		 */
		$defaults = array(
			'menu'				=> '',
			'container'			=> false, // WP Default div.
			'container_class'	=> false,
			'container_id'		=> false,
			'menu_class'		=> \sprintf(
				'nav navbar-nav %s',
				$this->config->get('navbar.main_menu_x_align')
			),
			'menu_id'			=> 'main-menu',
			'echo'				=> false,
			'fallback_cb'		=> $this->fallback_cb,
			'before'			=> '',
			'after'				=> '',
			'link_before'		=> '<span class="item-title" itemprop="name">',
			'link_after'		=> '</span>',
			'items_wrap'		=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'item_spacing'		=> 'preserve',
			'depth'				=> 10,
			'walker'			=> $this->walker,
			'theme_location'	=> 'main-menu',
			'search'			=> false,
		);

		$args = wp_parse_args( $args, $defaults );

		$args = apply_filters( 'italystrap_' . $args[ 'theme_location' ] . '_args', $args, $this->navbar_id );

		return wp_nav_menu( $args );
	}

	/**
	 * Get secondary wp-nav-menu
	 *
	 * @return false|null|string Return the secondary wp_nav_menu HTML
	 */
	public function get_secondary_wp_nav_menu() {// phpcs:ignore

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
	 * Get Brand
	 *
	 * @return string Return the HTML for brand name and/or image.
	 */
	public function get_brand() {// phpcs:ignore

		/**
		 * The ID of the logo image for navbar
		 * By default in the customizer is set a url for the image instead of an integer
		 * When it is choices an image than it will set an integer for $this->config['navbar_logo']
		 *
		 * @var integer
		 */
		$attachment_id = (int)apply_filters(
			'italystrap_navbar_logo_image_id',
			$this->config->get( 'navbar_logo_image' )
		);

		$brand = '';

		if ( $attachment_id && 'display_image' === $this->config[ 'display_navbar_brand' ] ) {
			$attr = array(
				'class' => 'img-brand img-responsive center-block',
				'alt' => esc_attr( $this->config->get( 'GET_BLOGINFO_NAME' ) )
					. ' &dash; '
					. esc_attr( $this->config->get( 'GET_BLOGINFO_DESCRIPTION' ) ),
				'itemprop' => 'image',
			);

			/**
			 * Size default: navbar-brand-image
			 */
			$brand .= wp_get_attachment_image(
				$attachment_id,
				$this->config[ 'navbar_logo_image_size' ],
				false,
				$attr
			);

			$brand .= '<meta  itemprop="name" content="'
				. esc_attr( $this->config->get( 'GET_BLOGINFO_NAME' ) ) . '"/>';
		} elseif ( $attachment_id && 'display_all' === $this->config[ 'display_navbar_brand' ] ) {
			$attr = array(
				'class' => 'img-brand img-responsive center-block',
				'alt' => esc_attr( $this->config->get( 'GET_BLOGINFO_NAME' ) )
					. ' - '
					. esc_attr( $this->config->get( 'GET_BLOGINFO_DESCRIPTION' ) ),
				'itemprop' => 'image',
				'style' => 'display:inline;margin-right:15px;',
			);

			/**
			 * Size default: navbar-brand-image
			 */
			$brand .= wp_get_attachment_image(
				$attachment_id,
				$this->config[ 'navbar_logo_image_size' ],
				false,
				$attr
			);

			$brand .= '<span class="brand-name" itemprop="name">'
				. esc_attr( $this->config->get( 'GET_BLOGINFO_NAME' ) ) . '</span>';
		} else {
			$brand .= '<span class="brand-name" itemprop="name">'
				. esc_attr( $this->config->get( 'GET_BLOGINFO_NAME' ) )
				. '</span>';
		}

		return $brand;
	}

	/**
	 * Get the HTML for description
	 *
	 * @param  array $attr The navbar brand attributes.
	 *
	 * @return string       Return the HTML for description
	 */
	public function get_navbar_brand( array $attr = array() ) {// phpcs:ignore

		if ( 'none' === $this->config[ 'display_navbar_brand' ] ) {
			return apply_filters( 'italystrap_navbar_brand_none', '', $this->navbar_id );
		}

//		return	$this->brand->render();

		$default = array(
			'class' => 'navbar-brand',
			'href' => esc_url( $this->config->get( 'HOME_URL' ) ),
			'title' => sprintf(
				'%s  -  %s',
				$this->config->get( 'GET_BLOGINFO_NAME' ),
				$this->config->get( 'GET_BLOGINFO_DESCRIPTION' )
			),
			'rel' => 'home',
			'itemprop' => 'url',
		);

		return $this->createElement(
			'navbar_brand',
			'a',
			array_merge( $default, $attr ),
			$this->get_brand()
		);
	}

	/**
	 * Get the HTML for toggle button
	 *
	 * @return string Return the HTML for toggle button
	 */
	public function get_toggle_button() {// phpcs:ignore

		$icon_bar = apply_filters(
			'italystrap_icon_bar',
			'<span class="icon-bar">&nbsp</span><span class="icon-bar">&nbsp</span><span class="icon-bar">&nbsp</span>'
		);

		$a = array(
			'class' => 'navbar-toggle',
			'data-toggle' => 'collapse',
			'data-target' => '#' . $this->navbar_id,
		);

//		$output = sprintf(
//			'<button%s><span class="sr-only">%s</span>%s</button>',
//			$this->get_attr( $a, 'toggle_button' ),
//			esc_attr__( 'Toggle navigation', 'italystrap' ),
//			$icon_bar
//		);
//
//		return apply_filters( 'italystrap_toggle_button', $output, $this->navbar_id );
		/**
		 * '<button%s><span class="sr-only">%s</span>%s</button>'
		 */
		return $this->createElement(
			'toggle_button',
			'button',
			$a,
			$this->createElement(
				'toggle_button_content',
				'span',
				['class' => 'sr-only screen-reader-text'],
				esc_attr__( 'Toggle navigation', 'italystrap' )
			) . trim( $icon_bar )
		);
	}

	/**
	 * Get the HTML for Navbar Header
	 *
	 * @return string Return the HTML for Navbar Header
	 */
	public function get_navbar_header() {// phpcs:ignore

		$a = [
			'class' => 'navbar-header',
			'itemprop' => 'publisher',
			'itemscope' => true,
			'itemtype' => 'https://schema.org/Organization',
		];

		return $this->createElement(
			'navbar_header',
			'div',
			$a,
			$this->get_navbar_brand() . $this->get_toggle_button()
		);
	}

	/**
	 * Get the collapsable HTML menu
	 *
	 * http://bootsnipp.com/snippets/featured/expanding-search-button-in-css
	 *
	 * @return string Return the HTML
	 */
	public function get_collapsable_menu() {// phpcs:ignore

		$a = [
			'id' => $this->navbar_id,
			'class' => 'navbar-collapse collapse',
		];

		return $this->createElement(
			'collapsable_menu',
			'div',
			$a,
			$this->get_wp_nav_menu() . $this->get_secondary_wp_nav_menu()
		);
	}

	/**
	 * A container inside the navbar-default/revers
	 *
	 * @return string The html output.
	 */
	public function get_last_container() {// phpcs:ignore
//		add_filter( 'italystrap_pre_last_container', '__return_true' );
		$a = [
			'id' => 'menus-container-' . $this->number,
			'class' => $this->config[ 'navbar' ][ 'menus_width' ],
		];

		return $this->createElement(
			'last_container',
			'div',
			$a,
			$this->get_navbar_header() . $this->get_collapsable_menu()
		);
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
	public function get_navbar_container() {// phpcs:ignore

		$a = [
			'class' => sprintf(
				'navbar %s %s',
				$this->config[ 'navbar' ][ 'type' ],
				$this->config[ 'navbar' ][ 'position' ]
			),
			'itemscope' => true,
			'itemtype' => 'https://schema.org/SiteNavigationElement',
		];

		return $this->createElement(
			'navbar_container',
			'nav',
			$a,
			$this->get_last_container()
		);
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
	public function get_nav_container() {// phpcs:ignore

//		if ( 'none' === $this->config[ 'navbar' ][ 'nav_width' ] ) {
//			return $this->get_navbar_container();
//		}

//		d( $this->config );

		$a = [
			'id'	=> 'main-navbar-container-' . $this->navbar_id,
			'class' => sprintf(
				'navbar-wrapper %s',
				$this->config[ 'navbar' ][ 'nav_width' ]
			),
		];

		return $this->createElement( 'nav_container', 'div', $a, $this->get_navbar_container() );
	}

	/**
	 * @param string $context
	 * @param string $tag
	 * @param array $attr
	 * @param string $content
	 * @return string
	 */
	private function createElement( string $context, string $tag, array $attr, string $content ) : string {

//		if ( !is_string( $context ) ) {
//			throw new \InvalidArgumentException( 'The $context variable must be a string', 0 );
//		}
//
//		if ( !is_string( $tag ) ) {
//			throw new \InvalidArgumentException( 'The $tag variable must be a string', 0 );
//		}
//
//		if ( !is_string( $content ) ) {
//			throw new \InvalidArgumentException( 'The $content variable must be a string', 0 );
//		}

		$content = (string)apply_filters( 'italystrap_' . $context . '_child', $content, $this->navbar_id );

		if ( empty( $content ) ) {
			$content = '&nbsp;';
		}

		if ( (bool) apply_filters( 'italystrap_pre_' . $context, false ) ) {
			return $content;
		}

		$tag = apply_filters( 'italystrap_' . $context . '_tag', $tag, $this->navbar_id );

		$output = sprintf(
			'<%1$s%2$s>%3$s</%1$s>',
			esc_attr( $tag ),
			$this->getAttr( $attr, $context ),
			$content
		);

		return apply_filters( 'italystrap_' . $context, $output, $this->navbar_id );
	}

	/**
	 * Render the HTML tag attributes from an array
	 *
	 * @param  array $attr The HTML attributes with key value.
	 * @param  string $context
	 *
	 * @return string          Return a string with HTML attributes
	 */
	private function getAttr( array $attr = [], $context = '' ) {
		return get_attr( $context, $attr, false, $this->navbar_id );
	}

	/**
	 * @return string
	 */
	public function render() {
		return $this->get_nav_container();
	}

	/**
	 * Output the HTML
	 */
	public function output(): void {
		echo $this->render();
	}
}
