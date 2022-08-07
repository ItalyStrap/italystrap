<?php
declare(strict_types=1);

namespace ItalyStrap\Customizer;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Config\ConfigThemeProvider;

class PanelFields {

	private \WP_Customize_Manager $manager;
	private ConfigInterface $config;

	public function __construct(
		\WP_Customize_Manager $manager,
		ConfigInterface $config
	) {
		$this->manager = $manager;
		$this->config = $config;
	}

	public function __invoke(): void {
		$this->manager->add_panel(
			self::class,
			[
				'title'			=> \sprintf(
					\__( '%s Options', 'italystrap' ),
					(string)$this->config->get( ConfigThemeProvider::THEME_NAME, '' )
				),
				'priority'		=> 10,
						]
		);
	}
}
