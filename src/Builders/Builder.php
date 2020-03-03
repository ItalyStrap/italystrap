<?php
/**
 * Builder API
 *
 * This builder class build the page structure from a given configuration.
 */
declare( strict_types = 1 );

namespace ItalyStrap\Builders;

use Auryn\InjectionException;
use Auryn\Injector;
use ItalyStrap\Event\EventDispatcherInterface as Dispatcher;
use ItalyStrap\View\ViewInterface as View;
use ItalyStrap\Config\ConfigInterface as Config;

class Builder implements Builder_Interface {

	const EVENT_NAME = 'event_name';

	/**
	 * @var View
	 */
	private $view;

	/**
	 * @var Config
	 */
	private $config;

	/**
	 * @var Injector
*/
	private $injector;

	/**
	 * @var array
	 */
	private $structure = [];
	/**
	 * @var Dispatcher
	 */
	private $dispatcher;

	/**
	 * Builder constructor.
	 * @param View $view
	 * @param Config $config
	 * @param Dispatcher $dispatcher
	 */
	public function __construct( View $view, Config $config, Dispatcher $dispatcher ) {
		$this->view = $view;
		$this->config = $config;
		$this->dispatcher = $dispatcher;
	}

	/**
	 * @param Injector $injector
	 * @return Builder
	 */
	public function set_injector( Injector $injector ) : self {
		$this->injector = $injector;
		return $this;
	}

	/**
	 * Build the page
	 *
	 * @throws \Exception
	 */
	public function build() {

		if ( ! $this->injector instanceof Injector ) {
			throw new \RuntimeException( sprintf(
				'You have to set the Injector with "%s::set_injector" before to load %s',
				__CLASS__,
				__METHOD__
			), 0 );
		}

		foreach ( $this->config as $component ) {
			$this->assertEventNameIsNotEmpty( $component );

			/**
			 * Merge with default
			 */
			$component = \array_merge( $this->get_default(), $component );

			/**
			 * If it should not be loaded bail out
			 */
			if ( ! $this->should_load( $component['should_load'] ) ) {
				continue;
			}

			$this->add_action( $component );

//			foreach ( (array) $component['hooks'] as $hook ) {
//				$this->add_action( $hook['event_name'], $component, $hook['priority'] );
//			}
		}
	}

	/**
	 * @param array $component
	 */
	private function add_action( array $component ) {

		\add_action( $component['event_name'], function ( ...$args ) use ( $component ) {

			$this->set_data( $component );

			echo $this->render_from_callback( $component );
		}, $component['priority'] );

//		$this->dispatcher->addListener( $component['event_name'], function ( ...$args ) use ( $component ) {
//
//			$this->set_data( $component );
//
//			echo $this->render_from_callback( $component );
//		}, $component['priority'] );
	}

	/**
	 * @param array $component
	 *
	 * @return string
	 * @throws InjectionException
	 * @throws \Exception
	 */
	private function render_from_callback( array $component ) : string {

		/**
		 * If callback is not defined we need to return a view
		 * from the View obj and the view file key must be defined.
		 */
		if ( ! $component['callback'] ) {
			return (string) $this->view->render(
				$this->get_the_view_relative_path( $component ),
				$component['data']
			);
		}

		$args = [
			':view' 		=> $this->get_the_view_relative_path( $component ),
			':data' 		=> $component['data'],
			':component'	=> $component,
		];

		foreach ( $component['callback_args'] as $name => $arg ) {
			$args[ ':' . $name ] = $arg;
		}

		return (string) $this->injector->execute( $component['callback'], $args );
	}

	/**
	 * @param array $component
	 * @throws InjectionException
	 */
	private function set_data( array &$component ) {

		/**
		 * Define the data array from optional callable
		 * $this->set_data( $component );
		 */
		if ( \is_callable( $component['data'] ) ) {
			$component['data'] = (array) $this->injector->execute( $component['data'] );
		}
	}

	/**
	 * @param array $component
	 * @return array
	 */
	private function get_the_view_relative_path( array $component ) : array {

		$view = (array) $component['view'];

		if ( ! isset( $view[0] ) ) {
			throw new \InvalidArgumentException( \__( 'If the callback is null you have to provide a file name to print for the View::class', 'italystrap' ), 0 );
		}

		return (array) $view;
	}

	/**
	 * @return array
	 */
	private function get_default() : array {
		return [
			static::EVENT_NAME	=> '',
			'view'			=> '', // Could be a string|array
			'data'			=> [], // Could be array|callable
			'priority'		=> 10, // Optional
			'callback'		=> null, // Optional
			'callback_args'	=> [], // Optional
			'should_load'	=> true,
		];
	}

	/**
	 * @param array $component
	 */
	private function assertEventNameIsNotEmpty( array $component ) {
		if ( ! \array_key_exists( 'event_name', $component ) || '' === $component['event_name'] ) {
			throw new \RuntimeException( \__( 'The event name must be not empty', 'italystrap' ), 0 );
		}
	}

	/**
	 * @param bool|callable $bool_Or_callable
	 * @return bool
	 * @throws InjectionException
	 */
	private function should_load( $bool_Or_callable ): bool {

		if ( \is_bool( $bool_Or_callable ) ) {
			return $bool_Or_callable;
		}

		return (bool) $this->injector->execute( $bool_Or_callable );
	}
}
