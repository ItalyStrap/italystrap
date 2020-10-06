<?php
declare( strict_types = 1 );

namespace ItalyStrap\Builders;

use Auryn\InjectionException;
use Auryn\Injector;
use ItalyStrap\Event\EventDispatcherInterface as Dispatcher;
use ItalyStrap\View\ViewInterface as View;
use ItalyStrap\Config\ConfigInterface as Config;

class Builder implements BuilderInterface {

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
	public function __construct( View $view, Config $config, Dispatcher $dispatcher, Injector $injector ) {
		$this->view = $view;
		$this->config = $config;
		$this->dispatcher = $dispatcher;
		$this->injector = $injector;
	}

	/**
	 * @param Injector $injector
	 * @return Builder
	 */
	public function setInjector( Injector $injector ) : self {
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
			$component = \array_merge( $this->getDefault(), $component );

			/**
			 * If it should not be loaded bail out
			 */
			if ( ! $this->shouldLoad( $component['should_load'] ) ) {
				continue;
			}

			$this->addAction( $component );

//			foreach ( (array) $component['hooks'] as $hook ) {
//				$this->add_action( $hook['event_name'], $component, $hook['priority'] );
//			}
		}
	}

	/**
	 * @param array $component
	 */
	private function addAction( array $component ) {

		\add_action( $component['event_name'], function ( ...$args ) use ( $component ) {

			$this->setData( $component );

			echo $this->renderFromCallback( $component );
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
	private function renderFromCallback( array $component ) : string {

		/**
		 * If callback is not defined we need to return a view
		 * from the View obj and the view file key must be defined.
		 */
		if ( ! $component['callback'] ) {
			return (string) $this->view->render(
				$this->getTheViewRelativePath( $component ),
				$component['data']
			);
		}

		$args = [
			':view' 		=> $this->getTheViewRelativePath( $component ),
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
	private function setData( array &$component ) {

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
	private function getTheViewRelativePath( array $component ) : array {

		$view = (array) $component['view'];
		// phpcs:disable
		if ( ! isset( $view[0] ) ) {
			throw new \InvalidArgumentException( \__( 'If the callback is null you have to provide a file name to print for the View::class', 'italystrap' ), 0 );
		}
		// phpcs:enable

		return (array) $view;
	}

	/**
	 * @return array
	 */
	private function getDefault() : array {
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
		if ( ! \array_key_exists(  static::EVENT_NAME, $component ) || '' === $component[ static::EVENT_NAME ] ) {
			throw new \RuntimeException( \__( 'The event name must be not empty', 'italystrap' ), 0 );
		}
	}

	/**
	 * @param bool|callable $bool_Or_callable
	 * @return bool
	 * @throws InjectionException
	 */
	private function shouldLoad( $bool_Or_callable ): bool {

		if ( \is_bool( $bool_Or_callable ) ) {
			return $bool_Or_callable;
		}

		return (bool) $this->injector->execute( $bool_Or_callable );
	}
}
