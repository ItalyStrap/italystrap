<?php
declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\Asset\Asset;
use ItalyStrap\Asset\ConfigBuilder as AssetConfigBuilder;
use ItalyStrap\Asset\Script;
use function admin_url;
use function defined;
use function ItalyStrap\Core\experimental_generate_asset_index_filename;
use function wp_create_nonce;

return [
	[
		Asset::HANDLE				=> CURRENT_TEMPLATE_SLUG,
		AssetConfigBuilder::FILE_NAME	=> experimental_generate_asset_index_filename( 'js' ),
		Asset::DEPENDENCIES			=> ['jquery'],
		Asset::IN_FOOTER			=> true,
		Asset::LOCALIZE				=> [
			Script::OBJECT_NAME	=> 'pluginParams',
			Script::PARAMS		=> [
				'ajaxurl'		=> admin_url( '/admin-ajax.php' ),
				'ajaxnonce'		=> wp_create_nonce( 'ajaxnonce' ),
				// 'api_endpoint'	=> site_url( '/wp-json/rest/v1/' ),
			],
		],
	],
	[
		Asset::HANDLE				=> 'comment-reply',
		Asset::SHOULD_LOAD			=> 'ItalyStrap\Core\is_comment_reply',
	],
];
