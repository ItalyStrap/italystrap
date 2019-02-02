<?php
/**
 * Define default theme constant
 *
 * Define default constant to use in the theme framework
 *
 * @link [URL]
 * @since 4.0.0
 *
 * @package ItalyStrap\Core
 */

namespace ItalyStrap\Core;

/**
 * Set default constant
 */
function set_default_constant( array $constant = [] ) {

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
function set_current_template( $current_template ) {

	define( 'CURRENT_TEMPLATE', basename( $current_template ) );
	define( 'CURRENT_TEMPLATE_SLUG', str_replace( '.php', '', CURRENT_TEMPLATE ) );

	return $current_template;
}
