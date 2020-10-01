<?php
declare( strict_types = 1 );

namespace ItalyStrap\Config;

use ItalyStrap\Event\SubscribersConfigExtension;

/**
 * @param  string $name
 *
 * @return string
 * @throws \InvalidArgumentException If the given file name does not exists
 */
function get_config_file_path( string $name ) {

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
function get_child_config_file_path( string $name ) {

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
 * @todo Se nel file richiesto c'è una variabile con lo stesso nome di quelle usate nella funzione
 *       ci possono essere dei problemi, in futuro trovare soluzione migliore, per il momento ho
 *       Nominato le variabili con nomi lunghi per evitare conflitti.
 *
 * @return array
 */
function get_config_file_content( string $name ) : array {

	$config_file_content = [];

	try {
		$config_file_content = (array) require get_config_file_path( $name );

		if ( $child_config_file_path = get_child_config_file_path( $name ) ) {
			$child_config_file_content = (array) require $child_config_file_path;
			$config_file_content = array_replace_recursive( $config_file_content, $child_config_file_content );
		}

	} catch ( \InvalidArgumentException $exception ) {
		echo $exception->getMessage();
	} catch ( \Exception $exception ) {
		echo $exception->getMessage();
	}

	/**
	 * // removes all NULL, FALSE and Empty Strings but leaves 0 (zero) values
	 * https://php.net/manual/en/function.array-filter.php#111091
	 */
	return array_filter( $config_file_content, __NAMESPACE__ . '\_filter_null_value', ARRAY_FILTER_USE_BOTH );
}

function _filter_null_value( $val, $key ) {
	return ! is_null( $val );
}

function dependencies_collection(): ConfigInterface {

	$dependencies_collection = get_config_file_content( 'dependencies' );
	$dependencies_collection[ SubscribersConfigExtension::SUBSCRIBERS ] = \array_merge(
		$dependencies_collection[ SubscribersConfigExtension::SUBSCRIBERS ],
		get_config_file_content( 'dependencies-admin' ),
		get_config_file_content( 'dependencies-front' )
	);

	/** @var ConfigInterface $dependencies */
	return ConfigFactory::make( $dependencies_collection );
}