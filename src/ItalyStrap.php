<?php
/**
 * ItalyStrap Framework Class
 *
 * This is the maim framework class for render the views of the theme 
 *
 * @link italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap;

use ItalyStrap\Config\Config;

/**
 * ItalyStrap
 */
class ItalyStrap {

	/**
	 * Configuration object
	 *
	 * @var null
	 */
	private $config = null;

	/**
	 * Default template directory
	 *
	 * @var string
	 */
	private $template_dir = '';

	/**
	 * Init the class
	 *
	 * @param Config $config The theme configuration object.
	 */
	function __construct( Config $config ) {
		$this->config = $config;
		$this->template_dir = apply_filters( 'italystrap_template_dir', 'templates' );
	}

	/**
	 * Render the view
	 *
	 * @param  string   $file_name The name of the file to load in the template directory.
	 * @param  callable $callback  [description]
	 */
	public function render( $file_name = 'index', $callback = null ) {

		if ( is_callable( $callback ) ) {
			call_user_func( $callback, $this );
		}

		require locate_template(
			$this->template_dir . DIRECTORY_SEPARATOR . $file_name . '.php'
		);

		do_action( 'italystrap' );
	}
}
