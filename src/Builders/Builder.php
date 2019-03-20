<?php
/**
 * Created by PhpStorm.
 * User: fisso
 * Date: 18/03/2019
 * Time: 15:20
 */

namespace ItalyStrap\Builders;


use ItalyStrap\Config\Config_Interface;
use ItalyStrap\Template\View_Interface;

class Builder implements Builder_Interface {

	private $config;
	private $view;
	private $injector;
	private $template_dir = '';

	/**
	 * Builder constructor.
	 * @param Config_Interface $config
	 * @param View_Interface $view
	 */
	public function __construct( Config_Interface $config, View_Interface $view ) {
		$this->config = $config;
		$this->view = $view;
		$this->template_dir = $this->config->get( 'template_dir' );
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

		/**
		 * @todo Verificare eventuali problemi di priorità con gli hook
		 */
		$structure = \ItalyStrap\Config\get_config_file_content( 'structure' );

		foreach ( $structure as $component ) {

			/**
			 * Merge with default
			 */
			$component = array_merge( $this->get_default(), $component );

			/**
			 * If it should not be loaded bail out
			 */
			if ( ! $component['should_load'] ) {
				continue;
			}

			$slug = $this->get_relative_path_of_the_view( $component );

			add_action( $component['hook'], function() use ( $slug, $component ) {

				/**
				 * Define the data array from optional callable
				 * $this->set_data( $component );
				 */
				if ( is_callable( $component['data'] ) ) {
					$component['data'] = (array) call_user_func( $component['data'], $component );
				}

				if ( ! $component['callback'] ) {
					echo $this->view->render( $slug, $component['data'] );
					return;
				}

				if ( $component['callback'] instanceof \Closure ) {
					echo $this->injector->execute( $component['callback'] );
					return;
				}

				if ( is_callable( [ $component['callback'], 'render' ] ) ) {
					$callable = $this->injector->make( $component['callback'] );
					echo $callable->render();
					return;
				}

//			d(is_scalar(''));

//			d( 'Closure::class', is_a( $component['callback'], \Closure::class ) );
//			d( 'Closure', is_a( $component['callback'], '\Closure' ) );
//
//			d($component['callback'],  is_callable( [ $component['callback'], 'render' ] ));
//			d($component['callback'],  is_callable( $component['callback'] ));
//
//			\ItalyStrap\Factory\get_injector()->execute( $component['callback'] );

//			if ( isset( $component['callback'] ) && is_callable( $component['callback'] ) ) {
//				call_user_func(  $component['callback'] );
//			}

			}, $component['priority'] );
		}
	}

	/**
	 * @param \Auryn\Injector $injector
	 * @return Builder
	 */
	public function set_injector( \Auryn\Injector $injector ) {
		$this->injector = $injector;
		return $this;
	}

	private function should_show() {
		return true;
	}

	/**
	 * @param array $component
	 * @return string
	 */
	private function get_relative_path_of_the_view( array $component ) {
		return $this->template_dir . DIRECTORY_SEPARATOR . $component['view'];
	}

	/**
	 * @return array
	 */
	private function get_default() {
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