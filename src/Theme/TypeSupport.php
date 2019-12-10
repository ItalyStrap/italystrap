<?php
declare(strict_types=1);

namespace ItalyStrap\Theme;

use \ItalyStrap\Config\ConfigInterface as Config;

class TypeSupport implements Registrable {

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
	 * @link http://codex.wordpress.org/Function_Reference/add_post_type_support
	 *
	 */
	public function register() {
		foreach ( $this->config as $post_type => $features ) {
			\add_post_type_support( $post_type, $features );
		}
	}
}