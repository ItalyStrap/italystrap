<?php
declare(strict_types=1);

namespace ItalyStrap\Css;

use \ItalyStrap\Event\SubscriberInterface;
use \ItalyStrap\Config\ConfigInterface;

/**
 * CSS API Class
 */
class Css implements SubscriberInterface {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked wp_head - 11
	 *
	 * @return array
	 */
	public function getSubscribedEvents(): array {

		return array(
			// 'hook_name'							=> 'method_name',
			'wp_head'	=> array(
				'function_to_add'	=> 'render',
				'priority'			=> 11,
			),
			'italystrap_custom_inline_style'	=> array(
				'function_to_add'	=> 'maybe_render',
				'priority'			=> PHP_INT_MAX,
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
//	private $theme_mods = array();

	/**
	 * Theme config.
	 *
	 * @var ConfigInterface
	 */
	private $config = array();

	private $css;

	/**
	 * [__construct description]
	 *
	 * @param ConfigInterface $config
	 * @param InlineGenerator $css
	 */
	function __construct( ConfigInterface $config, InlineGenerator $css ) {
		$this->config = $config;
		$this->css = $css;
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
	public function render() {

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

		$this->style .= $this->css->generate_css( '#site-title a', 'color', 'header_textcolor', '#' );

		$this->style .= $this->css->generate_css( 'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .heading', 'color', 'hx_textcolor' );
		/**
		 * $css .= $this->css->generate_css('body.custom-background', 'background-color', 'background_color', '#');
		 */
		$this->style .= $this->css->generate_css( 'a', 'color', 'link_textcolor' );
		/**
		 * $css .= $this->css->generate_css('.widget-title,.footer-widget-title', 'border-bottom-color', 'link_textcolor');
		 */

		$this->style .= $custom_css;

		$this->style .= apply_filters( 'italystrap_css_output', $this->style );

		if ( ! $this->style ) {
			return '';
		}

		if ( defined( 'ITALYSTRAP_PLUGIN' ) ) {
			return '';
		}

		 printf(
			 '<style type="text/css">%s</style>',
			 wp_strip_all_tags( $this->minify_output( $this->style ) )
		 );
	}

	/**
	 * @param string $css
	 * @return string
	 */
	public function maybe_render( string $css ) : string {
		return $this->style . $css;
	}

	/**
	 * Minify the CSS output
	 *
	 * @param  string $css The CSS output.
	 *
	 * @return string      The CSS minified
	 */
	public function minify_output( string $css ) : string {

		return $css = str_replace(
			[
				"\n",
				"\r",
				"\t",
				'&amp;nbsp;',
			],
			'',
			$css
		);
	}
}
