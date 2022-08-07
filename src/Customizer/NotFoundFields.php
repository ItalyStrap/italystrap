<?php
declare(strict_types=1);

namespace ItalyStrap\Customizer;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Config\ConfigNotFoundProvider;

class NotFoundFields {

	const SHOW_IMAGE = 'show';
	const HIDE_IMAGE = 'hide';

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
		$id = 'italystrap';

		$this->manager->add_section(
			self::class,
			[
				'title'			=> \__( '404 Page not found', 'italystrap' ),
				'panel'			=> PanelFields::class,
				'description'	=> \__( 'Customize the 404 page for this theme.', 'italystrap' ),
			]
		);

		$show_image = ConfigNotFoundProvider::SHOW_IMAGE;
		$this->manager->add_setting(
			ConfigNotFoundProvider::SHOW_IMAGE,
			[
				'default'			=> $this->config->get(ConfigNotFoundProvider::SHOW_IMAGE),
				'type'				=> 'theme_mod',
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'sanitize_text_field',
			]
		);

		$this->manager->add_control(
			"{$id}_{$show_image}",
			[
				'label'			=> \__( 'Show or hide 404 image', 'italystrap' ),
				'description'	=> \__( 'Select one option for showing or hiding the not found image.', 'italystrap' ),
				'section'		=> self::class,
				'settings'		=> ConfigNotFoundProvider::SHOW_IMAGE,
				'priority'		=> 10,
				'type'			=> 'radio',
				'choices'		=> [
					self::SHOW_IMAGE	=> \__( 'Show the 404 image', 'italystrap' ),
					self::HIDE_IMAGE	=> \__( 'Hide the 404 image', 'italystrap' ),
				],
			]
		);


		$this->manager->add_setting(
			ConfigNotFoundProvider::ID_IMAGE,
			[
				'default'			=> $this->config->get(ConfigNotFoundProvider::ID_IMAGE),
				'type'				=> 'theme_mod',
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'sanitize_text_field',
			]
		);

		$id_image = ConfigNotFoundProvider::ID_IMAGE;
		$this->manager->add_control(
			$this->control->make(
				\WP_Customize_Media_Control::class,
				$this->manager,
				"{$id}_{$id_image}",
				[
					'label'			=> \__( 'Default 404 Image', 'italystrap' ),
					'description'	=> \sprintf(
						// phpcs:disable
						\__( 'This is a default 404 image, it will be displayed in 404 page (must be at least %dpx width)', 'italystrap' ),
						// phpcs:enable
						$this->config->get('content_width')
					),
					'section'		=> self::class,
					'settings'		=> ConfigNotFoundProvider::ID_IMAGE,
					'priority'		=> 10,
				]
			)
		);

		$id_title = ConfigNotFoundProvider::TITLE;
		$this->manager->add_setting(
			ConfigNotFoundProvider::TITLE,
			[
				'default'			=> $this->config->get(ConfigNotFoundProvider::TITLE),
				'type'				=> 'theme_mod',
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'sanitize_text_field',
			]
		);

		$this->manager->add_control(
			"{$id}_{$id_title}",
			[
				'label'			=> \__( '404 Page Title', 'italystrap' ),
				'description'	=> \__( 'Add a title for the 404 page.', 'italystrap' ),
				'section'		=> self::class,
				'settings'		=> ConfigNotFoundProvider::TITLE,
				'priority'		=> 10,
				'type'			=> 'text',
			]
		);

		$this->manager->add_setting(
			ConfigNotFoundProvider::CONTENT,
			[
				'default'			=> $this->config->get(ConfigNotFoundProvider::CONTENT),
				'type'				=> 'theme_mod',
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'sanitize_text_field',
			]
		);

		$id_content = ConfigNotFoundProvider::CONTENT;
		$this->manager->add_control(
			"{$id}_{$id_content}",
			[
				'label'			=> \__( '404 Page Text', 'italystrap' ),
				'description'	=> \__( 'The text for the content for the 404 page. HTML allowed.', 'italystrap' ),
				'section'		=> self::class,
				'settings'		=> ConfigNotFoundProvider::CONTENT,
				'priority'		=> 10,
				'type'			=> 'textarea',
			]
		);
	}
}
