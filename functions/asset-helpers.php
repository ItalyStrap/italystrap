<?php
declare(strict_types=1);

namespace ItalyStrap\Core;

/**
 * @internal
 * @psalm-internal
 * @param string $extension
 * @return array
 */
function experimental_generate_asset_index_filename( string $extension ): array {
	$min = '.min';

	if ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) {
		$min = '';
	}

	return \array_unique(
		[
			CURRENT_TEMPLATE_SLUG . $min . '.' . $extension,
			CURRENT_TEMPLATE_SLUG . '.' . $extension,
			'index' . $min . '.' . $extension,
			'index.' . $extension,
			'custom' . $min . '.' . $extension,
			'custom.' . $extension,
		]
	);
}
