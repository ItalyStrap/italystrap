<?php
/**
 * Get the Injector instance
 */
declare(strict_types=1);
namespace ItalyStrap\Factory;

use Auryn\{ConfigException, InjectionException, Injector};
use ItalyStrap\Config\Config;
use ItalyStrap\Event\Manager;

if ( ! function_exists( '\ItalyStrap\Factory\injector' ) ) {

	/**
	 * @return Injector
	 */
	function injector() : Injector {

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
	 * @return \ItalyStrap\Config\Config
	 */
	function get_config() : Config {

		static $config = null;

		if ( ! $config ) {
			try {
				$config = injector()
					->alias( '\ItalyStrap\Config\Config_Interface',  \ItalyStrap\Config\Config::class )
					->share( \ItalyStrap\Config\Config::class )
					->make( \ItalyStrap\Config\Config::class );
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
	 * @return \ItalyStrap\View\View
	 */
	function get_view(): \ItalyStrap\View\View {

		static $view = null;

		if ( ! $view ) {
			try {
				$view = injector()
					->share( \ItalyStrap\View\View::class )
					->make( \ItalyStrap\View\View::class );
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
	 * @return \ItalyStrap\Event\Manager
	 */
	function get_event_manager() : Manager {

		static $event_manager = null;

		if ( ! $event_manager ) {
			try {
				$event_manager = injector()
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
