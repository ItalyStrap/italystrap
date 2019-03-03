<?php

namespace ItalyStrap\Config;

/**
 * @param Config_Interface $config
 * @param array $array_to_merge
 */
function merge_array_to_config( Config_Interface $config, array $array_to_merge = [] ) {
	$config->merge( $array_to_merge );
}

/**
 * Retrieve an array of config files.
 *
 *
 * @since 4.0.0
 * @access private
 *
 * @see \wp_get_mu_plugins() file wp-includes/load.php
 *
 * @return array Files to include.
 */
function get_config_files() {

	$config_files = [];
	$config_dir = PARENTPATH . '/config';

	if ( ! is_dir( $config_dir ) ) {
		return $config_files;
	}

	if ( ! $dh = opendir( $config_dir ) ) {
		return $config_files;
	}

	while ( ( $file = readdir( $dh ) ) !== false ) {
		if ( substr( $file, -4 ) === '.php' && 'index.php' !== $file ) {
			$key = str_replace( '.php', '', $file );
			$config_files[ $key ] = $config_dir . '/' . $file;
		}
	}

	closedir( $dh );

//	sort( $config_files );

	return (array) $config_files;
}

/**
 * @param  string $name
 *
 * @return string
 * @throws \InvalidArgumentException If the given file name does not exists
 */
function get_config_file_path( $name ) {

	$file_path = sprintf(
		'%s/../config/%s.php',
		__DIR__,
		$name
	);

	if ( ! file_exists( $file_path ) ) {
		throw new \InvalidArgumentException( sprintf( 'The file %s does not exists', $name ) );
	}

	return $file_path;
}

/**
 * @param  string $name
 *
 * @return string
 * @throws \InvalidArgumentException If the given file name does not exists
 */
function get_child_config_file_path( $name ) {

	$file_path = sprintf(
		'%s/config/%s.php',
		get_stylesheet_directory(),
		$name
	);

	if ( ! file_exists( $file_path ) ) {
		return null;
	}

	return $file_path;
}

/**
 * @param  string $name
 *
 * @return array
 */
function get_config_file_content( $name ) {

	$config = [];
	$child = [];

	try {
		$config = (array) require get_config_file_path( $name );

		if ( $child_path = get_child_config_file_path( $name ) ) {
			$child = (array) require $child_path;
			$config = array_replace_recursive( $config, $child );
		}

	} catch ( \InvalidArgumentException $exception ) {
		echo $exception->getMessage();
	} catch ( \Exception $exception ) {
		echo $exception->getMessage();
	}

	return (array) $config;
}