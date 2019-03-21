<?php
/**
 * Created by PhpStorm.
 * User: fisso
 * Date: 18/03/2019
 * Time: 15:20
 */

namespace ItalyStrap\Builders;


use \ItalyStrap\Config\Config_Interface;
use \ItalyStrap\Template\View_Interface;

class Builder implements Builder_Interface {

	private $config;
	private $view;
	private $injector;
	private $template_dir = '';
	private $structure = [];

	/**
	 * Builder constructor.
	 * @param Config_Interface $config
	 * @param View_Interface $view
	 */
	public function __construct( Config_Interface $config, View_Interface $view ) {
		$this->config = $config;
		$this->view = $view;
		$this->template_dir = (string) $this->config->get( 'template_dir' );
	}

	/**
	 * @param \Auryn\Injector $injector
	 * @return Builder
	 */
	public function set_injector( \Auryn\Injector $injector ) : Builder {
		$this->injector = $injector;
		return $this;
	}

	/**
	 * @param array $structure
	 * @return Builder
	 */
	public function set_structure( array $structure ) : Builder {
		$this->structure = $structure;
		return $this;
	}

	/**
	 * @throws \Exception
	 */
	public function build() {

		if ( ! $this->injector ) {
			throw new \Exception( sprintf(
				'You have to set the Injector with "%s::set_injector()" before to load %s',
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
		}
	}

	/**
	 * @param array $component
	 */
	private function add_action( array $component ) {

		\add_action( $component['hook'], function() use ( $component ) {

			/**
			 * Define the data array from optional callable
			 * $this->set_data( $component );
			 */
			if ( \is_callable( $component['data'] ) ) {
				$component['data'] = (array) \call_user_func( $component['data'], $component );
			}

			if ( ! $component['callback'] ) {
				echo $this->view->render(
					$this->get_relative_path_of_the_view( $component ),
					$component['data']
				);
				return;
			}

			if ( $component['callback'] instanceof \Closure ) {
				echo $this->injector->execute( $component['callback'] );
				return;
			}

			if ( \is_callable( [ $component['callback'], 'render' ] ) ) {
				$callable = $this->injector->make( $component['callback'] );
				echo $callable->render();
				return;
			}

		}, $component['priority'] );
	}

	/**
	 * @return bool
	 */
	private function should_show() : bool {
		return true;
	}

	/**
	 * @param array $component
	 * @return string|array
	 */
	private function get_relative_path_of_the_view( array $component ) {

		if ( is_array( $component['view'] ) ) {
			$component['view'][0] = $this->template_dir . DIRECTORY_SEPARATOR . $component['view'][0];
			return $component['view'];
		}

		return $this->template_dir . DIRECTORY_SEPARATOR . $component['view'];
	}

	/**
	 * @return array
	 */
	private function get_default() : array {
		return [
			'hook'			=> '',
			'view'			=> '', // Could be a string|array|callable
			'data'			=> [], // Could be array|callable
			'priority'		=> 10, // Optional
			'callback'		=> null, // Optional
			'should_load'	=> true,
		];
	}
}