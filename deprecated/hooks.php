<?php

/**
 * Example
 */
//add_filter('italystrap_require_theme_files_path', function ( $files ) {
//	$files[] = __DIR__ . '/index.php';
//	return $files;
//});

$message = "This filter was intended to load files from child theme after the parent theme loaded but now there is new method to do that, simply add <code>require_once get_template_directory() . '/lib/bootstrap.php'</code> in your child functions.php before all your code.";

/**
 * This filter is used to load your php file right after ItalyStrap theme is loaded.
 * The purpose is to have al code in the same scope without using global
 * with variables provided from this theme.
 *
 * Usage example:
 *
 * 1 - First of all you have to have the file/files with some code
 *     that extending this themes functionality in your theme path.
 * 2 - Than you have to activate your theme.
 * 3 - And then see the below example.
 *
 * add_filter( 'italystrap_require_theme_files_path', 'add_your_files_path' );
 *
 * function add_your_files_path( array $arg ) {
 *     return array_merge(
 *                  $arg,
 *                  array( STYLESHEETPATH . 'my-dir/my-file.php' )
 *     );
 * }
 * Important:
 * Remeber that the file you want to load just after ItalyStrap theme
 * has not to be required/included from your theme because
 * you will get an error 'You can't redeclare...'.
 *
 * @since 2.0.0
 *
 * @TODO Deprecated child autoload files, add message to the parameters
 *
 * @var array
 */
$theme_files_path = apply_filters_deprecated( 'italystrap_require_theme_files_path', [[]], '5.0', null, $message );

if ( ! empty( $theme_files_path ) ) {
	foreach ( (array) $theme_files_path as $key => $theme_file_path ) {
		if ( ! file_exists( $theme_file_path ) ) {
			throw new \Exception( sprintf( 'The file %s does not exists', $theme_file_path ) );
		}

		require $theme_file_path;
	}
	/**
	 * Fires once ItalyStrap Child theme has loaded.
	 *
	 * @since 2.0.0
	 */
	do_action( 'italystrap_child_theme_loaded' );
}