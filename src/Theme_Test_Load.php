<?php

namespace ItalyStrap;

use ItalyStrap\Config;

use Auryn\{Injector, ConfigException, InjectionException};
use ItalyStrap\Event\Manager;
use ItalyStrap\Config\Config_Interface;
use function ItalyStrap\Factory\{get_config, get_event_manager};

final class Theme_Test_Load implements Loadable_Test_Interface {

	/**
	 * Flag to track if the theme is loaded.
	 *
	 * @var bool
	 */
	private $loaded;

	/**
	 * @var array
	 */
	private $dependencies = [];

	/**
	 * @param array $dependencies
	 */
	public function set_dependencies( array $dependencies ) {
		$this->dependencies = $dependencies;
	}

	/**
	 * @param array $subscribers
	 */
	public function add_subscribers( array $subscribers = [] ) {
		$this->dependencies[ 'subscribers' ] = \array_merge( $this->dependencies[ 'subscribers' ], $subscribers );
	}

	/**
	 * @param Injector $injector
	 */
	public function register( Injector $injector ) {

		foreach ( $this->dependencies['sharing'] as $class ) {
			try {
				$injector->share( $class );
			} catch ( ConfigException $exception ) {
				echo $exception->getMessage();
			} catch ( \Exception $exception ) {
				echo $exception->getMessage();
			}
		}

		foreach ( $this->dependencies['aliases'] as $interface => $implementation ) {
			try {
				$injector->alias( $interface, $implementation );
			} catch ( ConfigException $exception ) {
				echo $exception->getMessage();
			} catch ( \Exception $exception ) {
				echo $exception->getMessage();
			}
		}

		foreach ( $this->dependencies['definitions'] as $class_name => $class_args ) {
			$injector->define( $class_name, $class_args );
		}

		foreach ( $this->dependencies['define_param'] as $param_name => $param_args ) {
			$injector->defineParam( $param_name, $param_args );
		}

		foreach ( $this->dependencies['delegations'] as $name => $callableOrMethodStr ) {
			try {
				$injector->delegate( $name, $callableOrMethodStr );
			} catch ( ConfigException $exception ) {
				echo $exception->getMessage();
			} catch ( \Exception $exception ) {
				echo $exception->getMessage();
			}
		}

		foreach ( $this->dependencies['preparations'] as $name => $callableOrMethodStr ) {
			try {
				$injector->prepare( $name, $callableOrMethodStr );
			} catch ( InjectionException $exception ) {
				echo $exception->getMessage();
			} catch ( \Exception $exception ) {
				echo $exception->getMessage();
			}
		}
	}

	/**
	 * @param Injector $injector
	 * @param Manager $event_manager
	 * @param Config_Interface $config
	 */
	private function apply( Injector $injector, Manager $event_manager, Config_Interface $config ) {

		foreach ( $this->dependencies['subscribers'] as $option_name => $concrete ) {
			try {

				/**
				 * Se è presente una chiave nelle opzioni e il valore è vuoto allora
				 * continua il ciclo
				 */
				if ( is_string( $option_name ) && $config->has( $option_name ) && empty( $config->get( $option_name ) ) ) {
					continue;
				}

				$event_manager->add_subscriber( $injector->make( $concrete ) );

			} catch ( InjectionException $exception ) {
				echo $exception->getMessage();
			} catch ( \Exception $exception ) {
				echo $exception->getMessage();
			}
		}
	}

	/**
	 * @param Injector $injector
	 * @return mixed|void
	 * @throws InjectionException
	 */
	public function load( Injector $injector ) {

		if ( $this->loaded ) {
			return;
		}

		$event_manager = get_event_manager();
		$config = get_config();

		// @TODO Maybe add an action here

		$this->register( $injector );
		$this->apply( $injector, $event_manager, $config );

		$this->loaded = true;

		// @TODO Maybe add an action here
	}
}