<?php
declare(strict_types=1);

/**
 * ========================================================================
 *
 * Autoload theme core files.
 *
 * ========================================================================
 */
$autoload_theme_files = [
	'core-booleans.php',
	'constants-generator.php',
	'asset-helpers.php',
	'config-helpers.php',
	'general-functions.php',
	'italystrap.php',
	'factory.php',
	'html.php',

	'images.php',
];

foreach ( $autoload_theme_files as $file ) {
	require __DIR__ . DIRECTORY_SEPARATOR .  $file;
}
