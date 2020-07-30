<?php
declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\Asset\Asset;
use ItalyStrap\Asset\ConfigBuilder;
use function defined;

$dev_dir = '';

if ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) {
	 $dev_dir = 'src/'; // Sistemare il path corretto per i font
}

return [
	[
		Asset::HANDLE				=> CURRENT_TEMPLATE_SLUG,
		ConfigBuilder::FILE_NAME	=> [
			$dev_dir . CURRENT_TEMPLATE_SLUG . '.css',
			$dev_dir . 'custom.css'
		],
	],
];
