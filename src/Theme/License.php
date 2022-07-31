<?php
declare(strict_types=1);

namespace ItalyStrap\Theme;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;

final class License implements SubscriberInterface {

	private ConfigInterface $config;
	private \WP_Theme $theme;

	public function getSubscribedEvents(): iterable {
		yield 'italystrap_theme_updater_config'	=> [
			SubscriberInterface::CALLBACK	=> '__invoke',
		];
	}

	public function __construct( \WP_Theme $theme, ConfigInterface $config ) {
		$this->config = $config;
		$this->theme = $theme;
	}

	public function __invoke( array $edd_config ): iterable {

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
				'version'        => $this->theme->display('Version'), // The current version of this theme
				'author'         => $this->theme->display('Author'), // The author of this theme
				'download_id'    => '', // Optional, used for generating a license renewal link
				'renew_url'      => '', // Optional, allows for a custom license renewal link
				'beta'           => $this->config->get('beta'), // Optional, set to true to opt into beta versions
			],
			'strings'	=> [
				'theme-license'             => \sprintf(
					/* translators: %s: Theme name */
					\__( '%s License', 'italystrap' ),
					$this->theme->display('Name')
				),
			],
		];

		return $edd_config;
	}
}
