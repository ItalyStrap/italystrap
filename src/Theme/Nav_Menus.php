<?php

namespace ItalyStrap\Theme;

use \ItalyStrap\Config\Config_Interface as Config;

class Nav_Menus implements Registrable {

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
	 * The class that implements this can be registered
	 */
	public function register() {
		\register_nav_menus( $this->config->all() );
	}
}