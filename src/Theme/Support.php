<?php

namespace ItalyStrap\Theme;

use \ItalyStrap\Config\Config_Interface as Config;

class Support implements Registrable {

	/**
	 * @var Config
	 */
	private $config;

	/**
	 * Init sidebars registration
	 */
	function __construct( Config $config ) {
		$this->config = $config;
	}

	/**
	 * Add theme supports
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support
	 *
	 * @param  array $theme_supports An array with theme support list.
	 */
	public function register() {
		foreach ( (array) $this->config as $feature => $parameters ) {
			if ( is_string( $parameters ) ) {
				\add_theme_support( $parameters );
			} else {
				\add_theme_support( $feature, $parameters );
			}
		}
	}
}