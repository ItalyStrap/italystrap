<?php

namespace ItalyStrap\Bool;

/**
 * @param string $needle
 * @return bool
 */
function should_( string $needle ) : bool {
	return \in_array( $needle, Core\get_template_settings(), true );
}