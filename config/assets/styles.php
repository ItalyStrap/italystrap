<?php
declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\Asset\Asset;
use ItalyStrap\Asset\ConfigBuilder as AssetConfigBuilder;
use function defined;
$min = '.min';

if ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) {
	$min = '';
}

return [
	[
		Asset::HANDLE				=> CURRENT_TEMPLATE_SLUG,
		AssetConfigBuilder::FILE_NAME	=> \array_unique(
			[
				CURRENT_TEMPLATE_SLUG . $min . '.css',
				CURRENT_TEMPLATE_SLUG . '.css',
				'custom' . $min . '.css',
				'custom.css',
			]
		),
	],
];
