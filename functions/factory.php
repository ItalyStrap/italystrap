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

if ( ! function_exists( '\ItalyStrap\Factory\get_view' ) ) {

	/**
	 * @return Config
	 */
	function get_view() {

		static $view = null;

		if ( ! $view ) {
			try {
				$view = get_injector()->share('\ItalyStrap\Template\View')->make( '\ItalyStrap\Template\View' );
			} catch ( ConfigException $configException ) {
				echo $configException->getMessage();
			} catch ( InjectionException $injectionException ) {
				echo $injectionException->getMessage();
			} catch ( \Exception $exception ) {
				echo $exception->getMessage();
			}
		}

		return $view;
	}
}

if ( ! function_exists( '\ItalyStrap\Factory\get_event_manager' ) ) {

	/**
	 * @return Config
	 */
	function get_event_manager() {

		static $event_manager = null;

		if ( ! $event_manager ) {
			try {
				$event_manager = get_injector()
					->share( \ItalyStrap\Event\Manager::class )
					->make( \ItalyStrap\Event\Manager::class );
			} catch ( ConfigException $configException ) {
				echo $configException->getMessage();
			} catch ( InjectionException $injectionException ) {
				echo $injectionException->getMessage();
			} catch ( \Exception $exception ) {
				echo $exception->getMessage();
			}
		}

		return $event_manager;
	}
}
