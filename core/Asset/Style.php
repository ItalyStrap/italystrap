<?php
/**
 * Style Class API
 *
 * Handle the JS regiter and enque
 *
 * @author      hellofromTonya
 * @link        http://hellofromtonya.github.io/Fulcrum/
 * @license     GPL-2.0+
 *
 * @since 2.0.0
 *
 * @package ItalyStrap\Core
 */

namespace ItalyStrap\Core\Asset;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

/**
 * Child class API for Style
 */
class Style extends Asset {

	/**
	 * De-register the style
	 *
	 * @since 2.0.0
	 */
	public function deregister( $handle ) {
		wp_dequeue_style( $handle );
		wp_deregister_style( $handle );
	}

	/**
	 * Pre register the style
	 *
	 * @since 2.0.0
	 */
	protected function pre_register( array $config = array() ) {

		wp_register_style(
			$config['handle'],
			$config['file'],
			$config['deps'],
			$config['version'],
			$config['media']
		);
	}

	/**
	 * Enqueue the style
	 *
	 * @since 2.0.0
	 */
	protected function enqueue( array $config = array() ) {

		wp_enqueue_style(
			$config['handle'],
			$config['file'],
			$config['deps'],
			$config['version'],
			$config['media']
		);
	}

	/**
	 * Get the default structure.
	 *
	 * @since 2.0.0
	 *
	 * @return array
	 */
	protected function get_default_structure() {

		return array(
			'handle'	=> '',
			'file'		=> null,
			'deps'		=> null,
			'version'	=> null,
			'media'		=> null,
		);
	}
}
