<?php
declare(strict_types=1);

namespace ItalyStrap\Theme;

use \ItalyStrap\Config\ConfigInterface as Config;
use ItalyStrap\Event\Subscriber_Interface;

class TypeSupport implements Registrable, Subscriber_Interface {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		return [
			'init'	=> self::CALLBACK,
		];
	}

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