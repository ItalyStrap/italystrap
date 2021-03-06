<?php
declare(strict_types=1);
namespace ItalyStrap\Bools;

use function \ItalyStrap\Core\get_template_settings;

/**
 * @param string $needle
 * @return bool
 */
function should_be( string $needle ) : bool {
	return \in_array( $needle, get_template_settings(), true );
}
