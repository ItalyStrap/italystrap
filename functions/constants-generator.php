<?php
/**
 * Define default theme constant
 *
 * Define default constant to use in the theme framework
 *
 * @since 4.0.0
 *
 * @package ItalyStrap\Core
 */
declare(strict_types=1);

namespace ItalyStrap\Core;

use function define;
use function defined;

/**
 * Set default constant
 * @param array $constant
 * @return array
 */
function set_default_constants( array $constant = [] ): array {

	foreach ( $constant as $name => $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	return $constant;
}

/**
 * Set Current Template Constant
 * Call this constant from after the 'get_header' action.
 *
 * @hooked template_include - 99998
 *
 * @param string $current_template Return the current temlate
 *
 * @return string
 */
function set_current_template_constants( $current_template ): string {

	define( 'CURRENT_TEMPLATE', basename( $current_template ) );
	define( 'CURRENT_TEMPLATE_SLUG', str_replace( '.php', '', CURRENT_TEMPLATE ) );

	return $current_template;
}
