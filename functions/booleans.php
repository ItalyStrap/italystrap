<?php
declare(strict_types=1);

namespace ItalyStrap\Bools;

use function \ItalyStrap\Core\get_template_settings;

/**
 * @param string $needle
 * @return bool
 */
//function should_be( string $needle ) : bool {
//	return \in_array( $needle, get_template_settings(), true );
//}

function experimental_is_block_theme(): bool {
	return
		\function_exists( 'gutenberg_is_fse_theme' ) && \gutenberg_is_fse_theme()
		|| \function_exists( 'gutenberg_is_block_theme' ) && \gutenberg_is_block_theme();
}

//function experimental_is_block_editor(): bool {
//
//	d( \get_current_screen() );
//
//	return true;
//}
