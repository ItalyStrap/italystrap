<?php
declare(strict_types=1);

namespace ItalyStrap\Theme;

use ItalyStrap\Config\ConfigInterface as Config;
use ItalyStrap\Event\SubscriberInterface;

/**
 * Class TextDomain
 * @package ItalyStrap\Theme
 */
class TextDomainSubscriber implements Registrable, SubscriberInterface {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @return array
	 */
	public function getSubscribedEvents(): array {

		return [
			// 'hook_name'							=> 'method_name',
			'italystrap_theme_load'	=> [
				static::CALLBACK	=> self::REGISTER_CB,
				static::PRIORITY	=> 20,
			],
		];
	}

	/**
	 * @var Config
	 */
	private $config;

	/**
	 * Init some functionality
	 * @param Config $config
	 */
	public function __construct( Config $config	) {
		$this->config = $config;
	}

	/**
	 *
	 */
	public function register() {

		/**
		 * Make theme available for translation.
		 */
		\load_theme_textdomain( 'italystrap', $this->config->get( 'PARENTPATH' ) . '/languages' );

//		if ( is_child_theme() ) {
//			\load_child_theme_textdomain( 'CHILD', $this->config->get( 'CHILDPATH' ) . '/languages' );
//		}
	}
}
