<?php
declare(strict_types=1);

namespace ItalyStrap\Customizer;

use ItalyStrap\Config\ConfigColophonProvider;
use ItalyStrap\Config\ConfigColorSectionProvider;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Config\ConfigThemeProvider;

class ColophonFields {

	const SECTION = 'colophon';

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
		$this->manager->add_section(
			self::class,
			[
				'title'				=> __( 'Footer\'s Colophon', 'italystrap' ),
				'description'		=> __( 'Add text for footer\'s colophon here', 'italystrap' ),
				'panel'				=> PanelFields::class,
				'priority'			=> 160,
				'theme_supports'	=> '',
			]
		);

		$this->manager->add_setting(
			ConfigColophonProvider::COLOPHON,
			[
				'default'			=> $this->config->get( ConfigColophonProvider::COLOPHON ),
				'type'				=> 'theme_mod',
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'wp_kses_post',
			]
		);

		$this->manager->add_control(
			ConfigColophonProvider::COLOPHON,
			[
				'label'			=> __( 'Footer\'s Colophon', 'italystrap' ),
				'description'	=> __( 'Add text for footer\'s colophon here', 'italystrap' ),
				'section'		=> self::class,
				'settings'		=> ConfigColophonProvider::COLOPHON,
				'priority'		=> 10,
				'type'			=> 'textarea',
			]
		);

		$this->manager->add_setting(
			ConfigColophonProvider::COLOPHON_ACTION,
			[
				'default'			=> $this->config->get( ConfigColophonProvider::COLOPHON_ACTION ),
				'type'				=> 'theme_mod',
				'transport'			=> 'refresh',
				'sanitize_callback'	=> 'sanitize_text_field',
			]
		);

		$this->manager->add_control(
			ConfigColophonProvider::COLOPHON_ACTION,
			[
				'label'			=> \__( 'Footer\'s Colophon Position', 'italystrap' ),
				'description'	=> \__( 'Add text for footer\'s colophon here', 'italystrap' ),
				'section'		=> self::class,
				'settings'		=> ConfigColophonProvider::COLOPHON_ACTION,
				'priority'		=> 10,
				'type'			=> 'select',
				'choices'		=> \apply_filters( 'italystrap_theme_positions', [] ),
			]
		);

		$this->manager->add_setting(
			ConfigColophonProvider::COLOPHON_PRIORITY,
			[
				'default'			=> $this->config->get( ConfigColophonProvider::COLOPHON_PRIORITY ),
				'type'				=> 'theme_mod',
				'transport'			=> 'refresh',
				'sanitize_callback'	=> 'sanitize_text_field',
			]
		);

		$this->manager->add_control(
			ConfigColophonProvider::COLOPHON_PRIORITY,
			[
				'label'			=> \__( 'Footer\'s Colophon Position', 'italystrap' ),
				'description'	=> \__( 'Add text for footer\'s colophon here', 'italystrap' ),
				'section'		=> self::class,
				'settings'		=> ConfigColophonProvider::COLOPHON_PRIORITY,
				'priority'		=> 10,
				'type'			=> 'number',
			]
		);
	}
}
