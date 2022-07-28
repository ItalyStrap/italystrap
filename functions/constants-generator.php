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
