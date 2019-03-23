<?php
/**
 * Builder API
 *
 * This builder class build the page structure from a given configuration.
 */
declare( strict_types = 1 );

namespace ItalyStrap\Builders;

use \ItalyStrap\Template\View_Interface;

class Builder implements Builder_Interface {

	/**
	 * @var View_Interface
	 */
	private $view;

	/**
	 * @var \Auryn\Injector
	 */
	private $injector;

	/**
	 * @var array
	 */
	private $structure = [];

	/**
	 * Builder constructor.
	 * @param View_Interface $view
	 */
	public function __construct( View_Interface $view ) {
		$this->view = $view;
	}

	/**
	 * @param \Auryn\Injector $injector
	 * @return Builder
	 */
	public function set_injector( \Auryn\Injector $injector ) : self {
		$this->injector = $injector;
		return $this;
	}

	/**
	 * @param array $structure
	 * @return Builder
	 */
	public function set_structure( array $structure ) : self {
		$this->structure = $structure;
		return $this;
	}

	/**
	 * Build the page
	 *
	 * @throws \Exception
	 */
	public function build() {

		if ( ! $this->injector ) {
			throw new \Exception( sprintf(
				'You have to set the Injector with "%s::set_injector" before to load %s',
					__CLASS__,
				__METHOD__
			), 0 );
		}

		foreach ( $this->structure as $component ) {

			/**
			 * Merge with default
			 */
			$component = \array_merge( $this->get_default(), $component );

			/**
			 * If it should not be loaded bail out
			 */
			if ( ! $component['should_load'] ) {
				continue;
			}

			$this->add_action( $component );

//			foreach ( (array) $component['hooks'] as $hook ) {
//				$this->add_action( $hook['hook'], $component, $hook['priority'] );
//			}
		}
	}

	/**
	 * @param array $component
	 */
	private function add_action( array $component ) {

		\add_action( $component['hook'], function() use ( $component ) {

			$this->set_data( $component );

			echo $this->render_from_callback( $component );

		}, $component['priority'] );
	}

	/**
	 * @param array $component
	 *
	 * @return string
	 * @throws \Auryn\InjectionException
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

		return (string) $this->injector->execute( $component['callback'], $args );
	}

	/**
	 * @param array $component
	 * @throws \Auryn\InjectionException
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
	 * @return string|array
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
			'hook'			=> '',
			'view'			=> '', // Could be a string|array
			'data'			=> [], // Could be array|callable
			'priority'		=> 10, // Optional
			'callback'		=> null, // Optional
			'should_load'	=> true,
		];
	}
}