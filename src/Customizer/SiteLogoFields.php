<?php
declare(strict_types=1);

namespace ItalyStrap\Customizer;

use ItalyStrap\Config\ConfigSiteLogoProvider;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Config\ConfigThemeProvider;
use ItalyStrap\Event\EventDispatcherInterface;

class SiteLogoFields {
	use BuildThumbnailSizeChoicesTrait, SizeChoicesTrait;

	public const SECTION = 'title_tagline';

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
		$prefix = $this->config->get(ConfigThemeProvider::PREFIX);

		$id_separator = 'separator';
		$this->manager->add_setting( $id_separator, [] );

		$this->manager->add_control(
			new class(
				$this->manager,
				"{$prefix}_$id_separator",
				[
					'section'		=> self::SECTION,
					'settings'		=> $id_separator,
					'priority'		=> 80,
				]
			) extends \WP_Customize_Control {
				// phpcs:disable
				protected function render_content() {
					echo '<label><br><hr class="separator"><br></label>';
				}
				// phpcs:enable
			}
		);

		$id_navbar_brand_display = 'display_navbar_brand';
		$this->manager->add_setting(
			$id_navbar_brand_display,
			[
				'default'			=> $this->config->get( ConfigSiteLogoProvider::DISPLAY_NAVBAR_BRAND_IMAGE ),
				'type'				=> 'theme_mod',
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'sanitize_text_field',
			]
		);

		$this->manager->add_control(
			"{$prefix}_{$id_navbar_brand_display}",
			[
				'settings'		=> $id_navbar_brand_display,
				'label'			=> \__( 'Display the navbar brand', 'italystrap' ),
				// phpcs:disable
				'description'	=> \__( 'Select the type of navbar brand to visualize or select to hide navbar brand, if you select to visualize navbar with image you also have to select the image and the size of the image to visualize in the above controls.', 'italystrap' ),
				// phpcs:enable
				'section'		=> self::SECTION,
				'type'			=> 'radio',
				'priority'		=> 80,
				'choices'		=> [
					'none'			=> \__( 'Hide navbar brand', 'italystrap' ),
					'display_image'	=> \__( 'Display navbar brand image', 'italystrap' ),
					'display_name'	=> \__( 'Display navbar brand name', 'italystrap' ),
					'display_all'	=> \__( 'Display navbar brand image and name', 'italystrap' ),
				],
			]
		);

//		d(\get_theme_mod('custom_logo'));
//		d(\get_option( 'site_logo' ));
//		d(\get_option( 'site_icon' ));
//		d($this->config);

		$old_logo_id = \get_theme_mod('logo');
		$brand_image_id = ConfigSiteLogoProvider::BRAND_IMAGE_ID;
		if ( ! empty( $old_logo_id ) ) {
			$this->config->add( 'navbar_logo_image', \absint( $old_logo_id ) );
			\set_theme_mod( 'navbar_logo_image', \absint( $old_logo_id ) );
			\update_option( 'site_logo', \absint( $old_logo_id ) );
			\remove_theme_mod( $brand_image_id );
		}

		$this->manager->add_setting(
			$brand_image_id,
			[
				'default'			=> $this->config->get($brand_image_id),
				'type'				=> 'theme_mod',
				'transport'			=> 'refresh',
				'sanitize_callback'	=> 'sanitize_text_field',
			]
		);

		$this->manager->add_control(
			new \WP_Customize_Media_Control(
				$this->manager,
				"{$prefix}_{$brand_image_id}",
				[
					'label'			=> \__( 'Your logo brand for nav menu', 'italystrap' ),
					'description'	=> \__( 'Insert here your logo brand for nav menu', 'italystrap' ),
					'section'		=> self::SECTION,
					'settings'		=> $brand_image_id,
					'priority'		=> 80,
				]
			)
		);

		$id_logo_img_size = ConfigSiteLogoProvider::BRAND_IMAGE_SIZE;
		$this->registerSizeChoicesFor(
			$prefix,
			$id_logo_img_size,
			\__( 'Logo image size', 'italystrap' ),
			self::SECTION,
			'select',
			80
		);
	}
}
