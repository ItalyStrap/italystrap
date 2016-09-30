<?php
/**
 * Abstract Asset Class API
 *
 * Handle the CSS and JS regiter and enque
 *
 * @since 2.0.0
 *
 * @package ItalyStrap\Core
 */

namespace ItalyStrap\Core;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

/**
 * Class description
 * @todo http://wordpress.stackexchange.com/questions/195864/most-elegant-way-to-enqueue-scripts-in-function-php-with-foreach-loop
 */
abstract class Asset {

	/**
	 * Configuration array
	 *
	 * @var array
	 */
	private $config = array();

	/**
	 * The Class name without namespace
	 *
	 * @var string
	 */
	private $class_name = '';

	/**
	 * Init the constructor
	 *
	 * @param array $config Configuration array.
	 */
	function __construct( array $config = array() ) {

		/**
		 * Credits:
		 * @link https://coderwall.com/p/cpxxxw/php-get-class-name-without-namespace
		 */
		$this->class_name =  ( new \ReflectionClass( $this ) )->getShortName();

		/**
		 * With this hook you can filter the enqueue script and style config
		 * Filters name:
		 * 'italystrap_config_enqueue_style'
		 * 'italystrap_config_enqueue_script'
		 *
		 * @var array
		 */
		$this->config = apply_filters( 'italystrap_config_enqueue_' . strtolower( $this->class_name ) , $config );
	}

	/**
	 * Register each of the asset (enqueues it)
	 *
	 * @since 2.0.0
	 *
	 * @return null
	 */
	public function register() {

		foreach ( $this->config as $config ) {

			$config = wp_parse_args( $config, $this->get_default_structure() );

			if ( isset( $config['deregister'] ) ) {
				$this->deregister( $config['handle'] );
			}

			if ( isset( $config['pre_register'] ) ) {
				$this->pre_register( $config );
				continue;
			}

			if ( $this->is_load_on( $config ) ) {
				$this->enqueue( $config );
			}
		}
	}

	/**
	 * De-register each of the asset
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	// abstract public function deregister();

	/**
	 * Loading asset conditionally.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	protected function is_load_on( $config ) {

		if ( ! isset( $config['load_on'] ) ) {
			return true;
		}

		if ( ! is_string( $config['load_on'] ) ) {
			return true;
		}

		return (bool) call_user_func( $config['load_on'] );
	}
}
