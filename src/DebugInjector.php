<?php
declare(strict_types=1);

namespace ItalyStrap;


use Auryn\ConfigException;
use Auryn\InjectionException;
use Auryn\Injector;
use Throwable;

class DebugInjector extends Empress\Injector
{
	/**
	 * @var Injector
	 */
	private $injector;

	public function __construct( Injector $injector ) {
		$this->injector = $injector;
	}

	public function define( $name, array $args ) {
		return $this->injector->define( $name, $args ); // TODO: Change the autogenerated stub
	}

	public function defineParam( $paramName, $value ) {
		return $this->injector->defineParam( $paramName, $value ); // TODO: Change the autogenerated stub
	}

	public function alias( $original, $alias ) {
		try {
			return $this->injector->alias( $original, $alias );
		} catch (ConfigException $e) {
			d( $e, $original, $alias );
			throw $e;
		}
	}

	public function share( $nameOrInstance ) {
		try {
			return $this->injector->share( $nameOrInstance );
		} catch (ConfigException $e) {
			d( $e, $nameOrInstance );
			throw $e;
		}
	}

	public function prepare( $name, $callableOrMethodStr ) {
		try {
			return $this->injector->prepare( $name, $callableOrMethodStr );
		} catch (InjectionException $e) {
			d( $e, $name, $callableOrMethodStr );
			throw $e;
		}
	}

	public function delegate( $name, $callableOrMethodStr ) {
		try {
			return $this->injector->delegate( $name, $callableOrMethodStr );
		} catch (ConfigException $e) {
			d( $e, $name, $callableOrMethodStr );
			throw $e;
		}
	}

	public function inspect( $nameFilter = null, $typeFilter = null ) {
		return $this->injector->inspect( $nameFilter, $typeFilter ); // TODO: Change the autogenerated stub
	}

	public function proxy( string $name, $callableOrMethodStr ) {
		return $this->injector->proxy( $name, $callableOrMethodStr ); // TODO: Change the autogenerated stub
	}

	public function make( $name, array $args = array() ) {
		try {
			return $this->injector->make( $name, $args );
		} catch (InjectionException $e) {
			d( $e, $name, $args );
			throw $e;
		}
	}

	public function execute( $callableOrMethodStr, array $args = array() ) {
		try {
			return $this->injector->execute( $callableOrMethodStr, $args );
		} catch (InjectionException $e) {
			d( $e, $callableOrMethodStr, $args );
			throw $e;
		}
	}

	public function buildExecutable( $callableOrMethodStr ) {
		try {
			return $this->injector->buildExecutable( $callableOrMethodStr );
		} catch (Throwable $e) {
			d( $e, $callableOrMethodStr );
			throw $e;
		}
	}
}