<?php
declare(strict_types=1);

namespace ItalyStrap\Customizer;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Config\ConfigPostThumbnailProvider;
use ItalyStrap\Event\EventDispatcherInterface;

class PostThumbnailFields {
	use BuildThumbnailSizeChoicesTrait, ComponentsWidthChoicesTrait;

	private \WP_Customize_Manager $manager;
	private ConfigInterface $config;
	private FieldControlFactory $control;
	private EventDispatcherInterface $dispatcher;

	public function __construct(
		\WP_Customize_Manager $manager,
		ConfigInterface $config,
		FieldControlFactory $control,
		EventDispatcherInterface $dispatcher
	) {
		$this->manager = $manager;
		$this->config = $config;
		$this->control = $control;
		$this->dispatcher = $dispatcher;
	}

	public function __invoke(): void {
		$id = 'italystrap';

		$this->manager->add_section(
			self::class,
			[
				'title'			=> __( 'Thumbnails', 'italystrap' ),
				'panel'			=> PanelFields::class,
				'description'	=> __( 'Allows you to customize image settings for ItalyStrap.', 'italystrap' ),
			]
		);

		$this->manager->add_setting(
			ConfigPostThumbnailProvider::POST_THUMBNAIL_ID_DEFAULT,
			[
				'default' => (int)$this->config->get(ConfigPostThumbnailProvider::POST_THUMBNAIL_ID_DEFAULT, 0),
				'type'				=> 'theme_mod',
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'sanitize_text_field',
			]
		);

		$id_default_image = ConfigPostThumbnailProvider::POST_THUMBNAIL_ID_DEFAULT;
		$this->manager->add_control(
			$this->control->make(
				\WP_Customize_Media_Control::class,
				$this->manager,
				"{$id}_{$id_default_image}",
				[
					'label'			=> \__( 'Default Image', 'italystrap' ),
					// phpcs:disable
					'description'	=> \__( 'It will be displayed if no feautured image will be added in your content page/post if the theme supports this feature.', 'italystrap' ),
					// phpcs:enable
					'section'		=> self::class,
					'settings'		=> ConfigPostThumbnailProvider::POST_THUMBNAIL_ID_DEFAULT,
					'priority'		=> 10,
				]
			)
		);

		$this->manager->add_setting(
			ConfigPostThumbnailProvider::POST_THUMBNAIL_SIZE,
			[
				'default'			=> (string)$this->config->get(ConfigPostThumbnailProvider::POST_THUMBNAIL_SIZE),
				'type'				=> 'theme_mod',
				'transport'			=> 'refresh',
				'sanitize_callback'	=> 'sanitize_text_field',
			]
		);

		$id_thumb_size = ConfigPostThumbnailProvider::POST_THUMBNAIL_SIZE;
		$this->manager->add_control(
			"{$id}_{$id_thumb_size}",
			[
				'settings'		=> ConfigPostThumbnailProvider::POST_THUMBNAIL_SIZE,
				'label'			=> \__( 'Post thumbnail size', 'italystrap' ),
				// phpcs:disable
				'description'	=> \__( 'Change image size of post thumbnail in archive, author, blog, category, search, and tag pages.', 'italystrap' ),
				// phpcs:enable
				'section'		=> self::class,
				'type'			=> 'select',
				'choices'		=> $this->buildSizeChoices(),
			]
		);

		$this->manager->add_setting(
			ConfigPostThumbnailProvider::POST_THUMBNAIL_ALIGNMENT,
			[
				'default' => (string)$this->config->get(ConfigPostThumbnailProvider::POST_THUMBNAIL_ALIGNMENT),
				'type'				=> 'theme_mod',
				'transport'			=> 'refresh',
				'sanitize_callback'	=> 'sanitize_text_field',
			]
		);

		$id_thumb_align = ConfigPostThumbnailProvider::POST_THUMBNAIL_ALIGNMENT;
		$this->manager->add_control(
			"{$id}_{$id_thumb_align}",
			[
				'settings'		=> ConfigPostThumbnailProvider::POST_THUMBNAIL_ALIGNMENT,
				'label'			=> \__( 'Archive post thumbnail alignment', 'italystrap' ),
				// phpcs:disable
				'description'	=> \__( 'Change image alignment of post thumbnail in archive, author, blog, category, search, and tag pages.', 'italystrap' ),
				// phpcs:enable
				'section'		=> self::class,
				'type'			=> 'select',
				'choices'		=> $this->getThumbnailAlignementsChoices(),
			]
		);
	}
}
