<?php
declare( strict_types = 1 );

namespace ItalyStrap\Config;

use ItalyStrap\Event\SubscribersConfigExtension;
use ItalyStrap\Experimental\PhpFileProvider;
use ItalyStrap\Finder\FinderFactory;
use ItalyStrap\Finder\FinderInterface;
use SplFileObject;
use function array_filter;
use function array_merge;
use function array_replace_recursive;
use function get_stylesheet_directory;
use function get_template_directory;
use function is_null;

/**
 * @param  string $name
 * @return array
 */
function get_config_file_content( string $name ) : array {

	/** @var array<int, SplFileObject> $files */
	$files = config_files_finder()->allFiles( $name );

	$config_file_content = [];
	foreach ( $files as $file ) {
		$config_file_content = array_replace_recursive(
			$config_file_content,
			(array) require $file
		);
	}

	/**
	 * removes all NULL, FALSE and Empty Strings but leaves 0 (zero) values
	 * https://php.net/manual/en/function.array-filter.php#111091
	 */
	return array_filter( $config_file_content, fn( $val ) => ! is_null( $val ) );
}

/**
 * This return the config from child if is active
 * otherwise it returns a config from the parent
 * @param  string $name
 * @return array
 */
function get_config_file_content_last( string $name ) : array {

	/** @var array<int, SplFileObject> $files */
	$files = config_files_finder()->allFiles( $name );
	$last_key = \array_key_last( $files );

	$config_file_content = require $files[ $last_key ];

	/**
	 * removes all NULL, FALSE and Empty Strings but leaves 0 (zero) values
	 * https://php.net/manual/en/function.array-filter.php#111091
	 */
	return array_filter( $config_file_content, fn( $val ) => ! is_null( $val ) );
}

/**
 * This function return a Finder object
 * with config dirs with this order:
 * 0 => Parent
 * 1 => Child
 * @return FinderInterface
 */
function config_files_finder(): FinderInterface {

	static $experimental_finder = null;

	if ( ! $experimental_finder ) {
		$experimental_finder = ( new FinderFactory() )
			->make()
			->in(
			[
				/**
				 * To remember:
				 * This is the correct hierarchy to load and override
				 * the parent with child config.
				 * @see get_config_file_content
				 */
				get_template_directory() . '/config/',
				get_stylesheet_directory() . '/config/',
			]
		);
	}

	return $experimental_finder;
}
