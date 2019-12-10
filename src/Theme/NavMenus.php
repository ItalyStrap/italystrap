<?php
declare(strict_types=1);

namespace ItalyStrap\Theme;

use \ItalyStrap\Config\ConfigInterface as Config;

class NavMenus implements Registrable {

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