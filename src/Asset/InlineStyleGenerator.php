<?php
declare(strict_types=1);

namespace ItalyStrap\Asset;

use ItalyStrap\Config\ConfigInterface;

/**
 * @todo Fluent methods? one https://github.com/izica/php-styles
 */
class InlineStyleGenerator {

	private ConfigInterface $config;

	public function __construct( ConfigInterface $config ) {
		$this->config = $config;
	}

	/**
	 * This will generate a line of CSS for use in header or footer output.
	 * If the setting ($mod_name) has no defined value, the CSS will not be output.
	 *
	 * @param string $selector CSS selector.
	 * @param string $property The name of the CSS *property* to modify.
	 * @param string $mod_name The name of the 'theme_mod' option to fetch.
	 * @param string $prefix Optional. Anything that needs to be output
	 *                          before the CSS property. Example '#'.
	 * @param string $postfix Optional. Anything that needs to be output
	 *                          after the CSS property. Example 'px'.
	 * @return string           Returns a single line of CSS with selectors,
	 *                          property and value.
	 */
	public function render(
		string $selector,
		string $property,
		string $mod_name,
		string $prefix,
		string $postfix = ''
	): string {

		$value = (string) $this->config->get( $mod_name );

		if ( empty( $value ) ) {
			return '';
		}

		return \sprintf(
			'%1$s{%2$s:%3$s%4$s%5$s;}',
			$selector,
			$property,
			$prefix,
			$value,
			$postfix
		);
	}
}
