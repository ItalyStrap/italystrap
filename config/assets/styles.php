<?php
declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\Asset\Asset;
use ItalyStrap\Asset\ConfigBuilder as AssetConfigBuilder;
use function defined;
use function ItalyStrap\Core\experimental_generate_asset_index_filename;

return [
	[
		Asset::HANDLE				=> CURRENT_TEMPLATE_SLUG,
		AssetConfigBuilder::FILE_NAME	=> experimental_generate_asset_index_filename( 'css' ),
	],
];
