<?php
/**
 * Script Class API
 *
 * Handle the JS regiter and enque
 *
 * @author      hellofromTonya
 * @link        http://hellofromtonya.github.io/Fulcrum/
 * @license     GPL-2.0+
 *
 * @since 4.0.0
 *
 * @package ItalyStrap\Core
 */

namespace ItalyStrap\Core\Asset;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

/**
 * Child class API for Script
 */
class Script extends Asset {

	/**
	 * De-register the script
	 *
	 * @since 4.0.0
	 *
	 * @return null
	 */
	public function deregister( $handle ) {
		wp_dequeue_script( $handle );
		wp_deregister_script( $handle );
	}

	/**
	 * Pre register the script
	 *
	 * @since 4.0.0
	 */
	protected function pre_register( array $config = array()  ) {

		wp_register_script(
			$config['handle'],
			$config['file'],
			$config['deps'],
			$config['version'],
			$config['in_footer']
		);
	}

	/**
	 * Enqueue the script
	 *
	 * @since 4.0.0
	 */
	protected function enqueue( array $config = array() ) {

		wp_enqueue_script(
			$config['handle'],
			$config['file'],
			$config['deps'],
			$config['version'],
			$config['in_footer']
		);
	}

	/**
	 * Localize the script
	 *
	 * @link https://developer.wordpress.org/reference/functions/wp_localize_script/
	 *
	 * @since 4.0.0
	 *
	 * @return null
	 */
	protected function localize_script( array $config = array() ) {

		wp_localize_script(
			$config['handle'],
			$config['localize']['object_name'],
			$config['localize']['params']
		);
	}

	/**
	 * Get the default structure.
	 *
	 * @since 4.0.0
	 *
	 * @return array
	 */
	protected function get_default_structure() {

		return array(
			'handle'	=> '',
			'file'		=> null,
			'deps'		=> null,
			'version'	=> null,
			'in_footer'	=> true,
			'localize'  => '',
		);
	}
}
