<?php
/**
 * Get the Injector instance
 */
declare(strict_types=1);

namespace ItalyStrap\Factory;

use Auryn\ConfigException;
use Auryn\InjectionException;
use Auryn\Injector as AurynInjector;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\DebugInjector;
use ItalyStrap\Empress\Injector as EmpressInjector;
use ItalyStrap\Config\Config;
use ItalyStrap\View\View;
use function ItalyStrap\Core\is_debug;

if ( ! function_exists( '\ItalyStrap\Factory\injector' ) ) {

	/**
	 * @return AurynInjector
	 * @throws ConfigException
	 */
	function injector(): AurynInjector {

		/**
		 * Injector from ACM if is active
		 */
		$injector = apply_filters( 'italystrap_injector', false );

		if ( ! $injector ) {
			$injector = new EmpressInjector();
			$injector->alias(AurynInjector::class, EmpressInjector::class);
			$injector->share($injector);
			add_filter( 'italystrap_injector', function () use ( $injector ) {
				return $injector;
			} );
		}

		if ( ! is_debug() ) {
			return $injector;
		}

		if ( ! ( $injector instanceof DebugInjector ) ) {
			$injector = new DebugInjector( $injector );
			$injector->alias(AurynInjector::class, DebugInjector::class);
			$injector->share($injector);
			add_filter( 'italystrap_injector', function () use ( $injector ) {
				return $injector;
			} );
		}

		return $injector;
	}
}

if ( ! function_exists( '\ItalyStrap\Factory\get_config' ) ) {

	/**
	 * @return ConfigInterface
	 */
	function get_config() : ConfigInterface {

		static $config = null;

		if ( ! $config ) {
			try {
				$config = injector()
					->alias( ConfigInterface::class, Config::class )
					->share( Config::class )
					->make( Config::class );
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
	 * @return View
	 */
	function get_view(): View {

		static $view = null;

		if ( ! $view ) {
			try {
				$view = injector()
					->share( View::class )
					->make( View::class );
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
