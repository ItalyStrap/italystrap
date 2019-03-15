<?php
/**
 * API for generating CSS with PHP
 *
 * This class manage the CSS creation and put it in the HTML of your page.
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Css;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

use ItalyStrap\Event\Subscriber_Interface;

/**
 * CSS API Class
 */
class Css implements Subscriber_Interface {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked wp_head - 11
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		return array(
			// 'hook_name'							=> 'method_name',
			'wp_head'	=> array(
				'function_to_add'	=> 'css_output',
				'priority'			=> 11,
			),
		);
	}

	/**
	 * The style output.
	 *
	 * @var string
	 */
	private $style = '';

	/**
	 * Theme theme mods.
	 *
	 * @var array
	 */
	private $theme_mods = array();

	/**
	 * [__construct description]
	 *
	 * @param [type] $argument [description].
	 */
	function __construct( array $theme_mods = array() ) {
		$this->theme_mods = $theme_mods;
	}

	/**
	 * Default custom background callback.
	 *
	 * @since 3.0.0
	 * @access protected
	 */
	public function custom_background_cb() {

		/**
		 * $background is the saved custom image, or the default image.
		 *
		 * @var string
		 */
		$background = set_url_scheme( get_background_image() );

		/**
		 * $color is the saved custom color.
		 * A default has to be specified in style.css. It will not be printed here.
		 *
		 * @var string
		 */
		$color = get_background_color();

		if ( get_theme_support( 'custom-background', 'default-color' ) === $color ) {
			$color = false;
		}

		if ( ! $background && ! $color ) {
			return;
		}

		$style = $color ? 'background-color:#' . $color . ';' : '';
		// d( get_theme_support( 'custom-background', 'default-repeat' ) );
		// d( $this->theme_mods );
		if ( $background ) {
			$image = 'background-image:url(' . $background . ');';

			$repeat = get_theme_mod( 'background_repeat', get_theme_support( 'custom-background', 'default-repeat' ) );

			if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ), true ) ) {
				$repeat = 'repeat';
			}

			$repeat = 'background-repeat:' . $repeat . ';';

			$position = get_theme_mod( 'background_position_x', get_theme_support( 'custom-background', 'default-position-x' ) );

			if ( ! in_array( $position, array( 'center', 'right', 'left' ), true ) ) {
				$position = 'left';
			}

			$position = 'background-position: top ' . $position . ';';

			$attachment = get_theme_mod( 'background_attachment', get_theme_support( 'custom-background', 'default-attachment' ) );

			if ( ! in_array( $attachment, array( 'fixed', 'scroll' ), true ) ) {
				$attachment = 'scroll';
			}

			$attachment = 'background-attachment: ' . $attachment . ';';

			$style .= $image . $repeat . $position . $attachment;

		}

		$this->style .= 'body.custom-background{' . trim( $style ) . '}';
	}

	/**
	 * This will generate a line of CSS for use in header or footer output.
	 * If the setting ($mod_name) has no defined value, the CSS will not be output.
	 *
	 * @since ItalyStrap 1.0
	 *
	 * @param  string $selector CSS selector.
	 * @param  string $property The name of the CSS *property* to modify.
	 * @param  string $mod_name The name of the 'theme_mod' option to fetch.
	 * @param  string $prefix   Optional. Anything that needs to be output
	 *                          before the CSS property. Example '#'.
	 * @param  string $postfix  Optional. Anything that needs to be output
	 *                          after the CSS property. Example 'px'.
	 * @param  bool   $echo     Optional. Whether to print directly to the page
	 *                          (default: true).
	 *
	 * @return string           Returns a single line of CSS with selectors,
	 *                          property and value.
	 */
	protected function generate_css( $selector, $property, $mod_name, $prefix = '', $postfix = '', $echo = false ) {

		/**
		 * Get theme mod by mod_name
		 *
		 * @var string
		 */
		$mod = $this->theme_mods[ $mod_name ];

		/**
		 * If mod is empty return
		 */
		if ( empty( $mod ) ) {
			return '';
		}

		/**
		 * CSS style from customizer
		 *
		 * @var string
		 */
		// $return = $selector . '{' . $property . ':' . $prefix . $mod . $postfix . ';}';

		// return $return;
		return sprintf(
			'%1$s{%2$s:%3$s%4$s%5$s;}',
			$selector,
			$property,
			$prefix,
			$mod,
			$postfix
		);

	}

	/**
	 * This will output the custom WordPress settings to the live theme's WP head.
	 *
	 * Used by hook: 'wp_head'
	 *
	 * @see add_action( 'wp_head', $func )
	 * @see add_action( 'wp_footer', $func )
	 *
	 * @since ItalyStrap 1.0
	 */
	public function css_output() {

		$test_style = array(
			'selector'	=> '',
			'property'	=> '',
			'value'		=> '',
		);

		// echo "<pre>";
		// print_r('navbar-fixed-top' === $this->theme_mods['navbar']['position'] );
		// echo "</pre>";

		/**
		 * Custom CSS section on customizer page
		 *
		 * Il custom_css è gestito dal plugin, valutare una falback in caso il plugin è disattivato.
		 *
		 * @var string
		 */
		// $custom_css = isset( $this->theme_mods['custom_css'] ) ? $this->theme_mods['custom_css'] : '' ;
		$custom_css = '';

		$this->style .= $this->generate_css( '#site-title a', 'color', 'header_textcolor', '#' );

		$this->style .= $this->generate_css( 'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .heading', 'color', 'hx_textcolor' );
		/**
		 * $css .= $this->generate_css('body.custom-background', 'background-color', 'background_color', '#');
		 */
		$this->style .= $this->generate_css( 'a', 'color', 'link_textcolor' );
		/**
		 * $css .= $this->generate_css('.widget-title,.footer-widget-title', 'border-bottom-color', 'link_textcolor');
		 */

		$this->style .= $custom_css;

		$this->style .= apply_filters( 'italystrap_css_output', $this->style );

		$style = $this->style;

		add_filter( 'italystrap_custom_inline_style', function ( $css ) use ( $style ) {
			return $style . $css;
		}, PHP_INT_MAX, 1 );

		// printf(
		// 	'<style type="text/css" id="custom-background-css">%s</style>',
		// 	wp_strip_all_tags( $this->minify_output( $this->style ) )
		// );

	}

	/**
	 * Minify the CSS output
	 *
	 * @param  string $css The CSS output.
	 *
	 * @return string      The CSS minified
	 */
	public function minify_output( $css ) {

		return $css = str_replace(
			array(
				"\n",
				"\r",
				"\t",
				'&amp;nbsp;',
			),
			'',
			$css
		);
	}
}
