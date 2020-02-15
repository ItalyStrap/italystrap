<?php
/**
 * Created by PhpStorm.
 * User: fisso
 * Date: 05/04/2019
 * Time: 15:12
 */

namespace ItalyStrap\Css;

use ItalyStrap\Config\ConfigInterface;

/**
 * Class Inline_Generator
 *
 * @todo maybe it could be an idea to integrate with some fluent methods like this one https://github.com/izica/php-styles
 *
 * @package ItalyStrap\Css
 */
class Inline_Generator {

	private $config;

	public function __construct( ConfigInterface $config ) {
		$this->config = $config;
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
	 * @param  string $prefix Optional. Anything that needs to be output
	 *                          before the CSS property. Example '#'.
	 * @param  string $postfix Optional. Anything that needs to be output
	 *                          after the CSS property. Example 'px'.
	 * @return string           Returns a single line of CSS with selectors,
	 *                          property and value.
	 */
	public function generate_css( $selector, $property, $mod_name, $prefix = '', $postfix = '' ) : string {

		/**
		 * Get theme mod by mod_name
		 *
		 * @var string
		 */
		$mod = $this->config->get( $mod_name );

		/**
		 * If mod is empty return
		 */
		if ( empty( $mod ) ) {
			return '';
		}

		return sprintf(
			'%1$s{%2$s:%3$s%4$s%5$s;}',
			$selector,
			$property,
			$prefix,
			$mod,
			$postfix
		);
	}

}