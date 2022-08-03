<?php
declare(strict_types=1);

namespace ItalyStrap\Css;

use ItalyStrap\Config\ConfigColorSectionProvider;
use \ItalyStrap\Event\SubscriberInterface;

/**
 * @deprecated
 */
class CssSubscriber implements SubscriberInterface {

	public function getSubscribedEvents(): array {

		return array(
			// 'hook_name'							=> 'method_name',
			'wp_head'	=> array(
				'function_to_add'	=> 'render',
				'priority'			=> 11,
			),
			'italystrap_custom_inline_style'	=> array(
				'function_to_add'	=> 'maybeRender',
				'priority'			=> PHP_INT_MAX,
			),
		);
	}

	private string $style = '';
	private InlineGenerator $css;

	public function __construct( InlineGenerator $css ) {
		$this->css = $css;
	}

	/**
	 * @since ItalyStrap 1.0
	 */
	public function render() {

		$test_style = array(
			'selector'	=> '',
			'property'	=> '',
			'value'		=> '',
		);

		/**
		 * Custom CSS section on customizer page
		 *
		 * Il custom_css è gestito dal plugin, valutare una falback in caso il plugin è disattivato.
		 *
		 * @var string
		 */
		$custom_css = '';

		$this->style .= $this->css->generateCss(
			'#site-title a',
			'color',
			'header_textcolor',
			'#'
		);

		$this->style .= $this->css->generateCss(
			'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .heading',
			'color',
			ConfigColorSectionProvider::HX_COLOR
		);
		/**
		 * $css .= $this->css->generate_css('body.custom-background', 'background-color', 'background_color', '#');
		 */
		$this->style .= $this->css->generateCss(
			'a',
			'color',
			ConfigColorSectionProvider::LINK_COLOR
		);
		/**
		 * $css .= $this->css->generate_css(
		 * '.widget-title,.footer-widget-title', 'border-bottom-color', 'link_textcolor');
		 */

		$this->style .= $custom_css;

		$this->style .= apply_filters( 'italystrap_css_output', $this->style );

		if ( ! $this->style ) {
			return;
		}

		if ( defined( 'ITALYSTRAP_PLUGIN' ) ) {
			return;
		}

		 printf(
			 '<style>%s</style>',
			 wp_strip_all_tags( $this->minifyOutput( $this->style ) )
		 );
	}

	/**
	 * @param string $css
	 * @return string
	 */
	public function maybeRender( string $css ) : string {
		return $this->style . $css;
	}

	/**
	 * Minify the CSS output
	 *
	 * @param  string $css The CSS output.
	 *
	 * @return string      The CSS minified
	 */
	public function minifyOutput( string $css ) : string {

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
