<?php

namespace ItalyStrap;

use ItalyStrap\Config;

use Auryn\Injector;
use Auryn\ConfigException;
use Auryn\InjectionException;

final class Theme_Test_Load implements Loadable_Test_Interface {

	/**
	 * Flag to track if the plugin is loaded.
	 *
	 * @var bool
	 */
	private $loaded;

	private $dependencies = [];

	public function set_dependencies( array $dependencies ) {
		$this->dependencies = $dependencies;
	}

	public function add_concretes( array $concrete = [] ) {
		$this->dependencies[ 'concretes' ] = array_merge( $this->dependencies[ 'concretes' ], $concrete );
	}

	public function before( Injector $injector ) {

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

		foreach ( $this->dependencies['execute'] as $callableOrMethodStr => $args ) {
//			d( $callableOrMethodStr, $args );
			try {
				$injector->execute( $callableOrMethodStr, $args );
			} catch ( InjectionException $exception ) {
				echo $exception->getMessage();
			} catch ( \Exception $exception ) {
				echo $exception->getMessage();
			}
		}
	}

	/**
	 * @param Injector $injector
	 * @throws InjectionException
	 */
	private function apply( Injector $injector ) {

		$event_manager = $injector->make( 'ItalyStrap\Event\Manager' );
		$config = $injector->make( 'ItalyStrap\Config\Config' );

		foreach ( $this->dependencies['concretes'] as $option_name => $concrete ) {
			try {

				/**
				 * Se è presente una chiave nelle opzioni e il valore è vuoto allora
				 * continua il ciclo
				 */
				if ( is_string( $option_name ) && $config->has( $option_name ) && empty( $config->get( $option_name ) ) ) {
					continue;
				}

				if ( method_exists( $concrete, 'get_subscribed_events' ) ) {
					$event_manager->add_subscriber( $injector->make( $concrete ) );
				} else {
					$injector->make( $concrete );
				}

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

//		@TODO add an action here

		$this->before( $injector );
		$this->apply( $injector );

		$this->loaded = true;

//		@TODO add an action here
	}
}