<?php
declare(strict_types=1);

namespace ItalyStrap\Customizer;

use ItalyStrap\Config\ConfigColorSectionProvider;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Config\ConfigThemeProvider;

class ColorFields {

	public const SECTION = 'colors';

	private \WP_Customize_Manager $manager;
	private ConfigInterface $config;
	private FieldControlFactory $control;

	public function __construct(
		\WP_Customize_Manager $manager,
		ConfigInterface $config,
		FieldControlFactory $control
	) {
		$this->manager = $manager;
		$this->config = $config;
		$this->control = $control;
	}

	public function __invoke(): void {
		$this->manager->get_setting( ConfigColorSectionProvider::HEADER_COLOR )->transport = 'postMessage';
		$this->manager->get_setting( ConfigColorSectionProvider::BG_COLOR )->transport = 'postMessage';
		$this->manager->get_section( self::SECTION )->title = \__( 'Theme Colors', 'italystrap' );

		$id_link_color = ConfigColorSectionProvider::LINK_COLOR;
		$prefix = $this->config->get(ConfigThemeProvider::PREFIX);

		$this->manager->add_setting(
			$id_link_color,
			[
				'default'			=> $this->config->get($id_link_color),
				'type'				=> 'theme_mod',
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'sanitize_hex_color',
			]
		);

		$this->manager->add_control(
			$this->control->make(
				\WP_Customize_Color_Control::class,
				$this->manager,
				"{$prefix}_{$id_link_color}",
				[
					'label'		=> \__( 'Link Color', 'italystrap' ),
					'section'	=> self::SECTION,
					'settings'	=> $id_link_color,
					'priority'	=> 10,
				]
			)
		);

		$id_hx_color = ConfigColorSectionProvider::HX_COLOR;
		$this->manager->add_setting(
			$id_hx_color,
			[
				'default'			=> $this->config->get($id_hx_color),
				'type'				=> 'theme_mod',
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'sanitize_hex_color',
			]
		);

		$this->manager->add_control(
			$this->control->make(
				\WP_Customize_Color_Control::class,
				$this->manager,
				"{$prefix}_{$id_hx_color}",
				[
					'label'		=> \__( 'Heading Color', 'italystrap' ),
					'section'	=> self::SECTION,
					'settings'	=> $id_hx_color,
					'priority'	=> 10,
				]
			)
		);
	}
}
