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
	'edd.php',
	'default-constants.php',
	'config-helpers.php',
	'general-functions.php',
	'comments-helpers.php',
	'italystrap.php',
	'factory.php',
	'event.php',
	'html.php',

	'images.php',
	'pointer.php',
];

/**
 * ========================================================================
 *
 * Do you want to load deprecated files?
 *
 * ========================================================================
 */
if ( \apply_filters( 'italystrap_load_deprecated', false ) ) {
	$autoload_theme_files[] = '../deprecated/autoload.php';
}

foreach ( $autoload_theme_files as $file ) {
	require __DIR__ . DIRECTORY_SEPARATOR .  $file;
}
