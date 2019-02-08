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