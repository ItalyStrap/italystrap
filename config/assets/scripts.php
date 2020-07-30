<?php
declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\Asset\Asset;
use ItalyStrap\Asset\ConfigBuilder;
use ItalyStrap\Asset\Script;
use function admin_url;
use function defined;
use function wp_create_nonce;

$min = '.min';
$dev_dir = '';

if ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) {
	$dev_dir = 'src/';
	$min = '';
}

return [
	[
		Asset::HANDLE				=> CURRENT_TEMPLATE_SLUG,
		ConfigBuilder::FILE_NAME	=> [
			$dev_dir . CURRENT_TEMPLATE_SLUG . $min . '.js',
			$dev_dir . 'custom' . $min . '.js',
		],
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
