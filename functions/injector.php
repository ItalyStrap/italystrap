<?php
/**
 * Get the Injector instance
 */

namespace ItalyStrap\Factory;

use Auryn\ConfigException;
use Auryn\InjectionException;
use Auryn\Injector;
use ItalyStrap\Config\Config;

if ( ! function_exists( '\ItalyStrap\Factory\get_injector' ) ) {

	/**
	 * @return Injector
	 */
	function get_injector() {

		/**
		 * Injector from ACM if is active
		 */
		$injector = apply_filters( 'italystrap_injector', null );

		if ( ! $injector ) {
			$injector = new Injector();
			add_filter( 'italystrap_injector', function () use ( $injector ) {
				return $injector;
			} );
		}

		return $injector;
	}
}

if ( ! function_exists( '\ItalyStrap\Factory\get_config' ) ) {

	/**
	 * @return Config
	 */
	function get_config() {

		static $config = null;

		if ( ! $config ) {
			try {
				$config = get_injector()->share('\ItalyStrap\Config\Config')->make( '\ItalyStrap\Config\Config' );
			} catch ( ConfigException $configException ) {
				echo $configException->getMessage();
			} catch ( InjectionException $injectionException ) {
				echo $injectionException->getMessage();
			} catch ( \Exception $exception ) {
				echo $exception->getMessage();
			}
		}

		return $config;
	}
}
