<?php
declare(strict_types=1);

namespace ItalyStrap\Theme;

use ItalyStrap\Config\Config;
use ItalyStrap\Event\EventDispatcher;
use ItalyStrap\Event\SubscriberInterface;

final class License implements Registrable, SubscriberInterface {

	public function getSubscribedEvents(): iterable {
		yield 'after_setup_theme'	=> [
			SubscriberInterface::CALLBACK	=> Registrable::REGISTER_CB,
			SubscriberInterface::PRIORITY	=> 21,
		];
	}

	/**
	 * @var Config
	 */
	private $config;

	/**
	 * Init sidebars registration
	 */
	public function __construct( Config $config, EventDispatcher $event ) {
		$this->config = $config;
		$this->event = $event;
	}

	/**
	 * @return void
	 */
	public function register() {
		$this->event->addListener(
			'italystrap_theme_updater_config',
			[ $this, 'edd' ]
		);
	}

	public function edd( array $edd_config ): array {

		/**
		 * EDD configuration for this theme
		 *
		 * @link italystrap.com
		 * @since 4.0.0
		 *
		 * @package ItalyStrap
		 */

		$item_name = 'ItalyStrap Theme Framework';
		$theme_slug = 'italystrap';

		$edd_config[] = [
			'config'	=> [
				'item_name'      => $item_name, // Name of theme
				'theme_slug'     => $theme_slug, // Theme slug
				'version'        => $this->config->get('ITALYSTRAP_THEME_VERSION'), // The current version of this theme
				'author'         => $this->config->get('ITALYSTRAP_THEME_AUTHOR'), // The author of this theme
				'download_id'    => '', // Optional, used for generating a license renewal link
				'renew_url'      => '', // Optional, allows for a custom license renewal link
				'beta'           => $this->config->get('beta'), // Optional, set to true to opt into beta versions
			],
			'strings'	=> [
				'theme-license'             => \sprintf(
					/* translators: %s: Theme name */
					\__( '%s License', 'italystrap' ),
					$this->config->get('ITALYSTRAP_THEME_NAME')
				),
			],
		];

		return $edd_config;
	}
}
