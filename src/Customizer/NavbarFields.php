<?php
declare(strict_types=1);

namespace ItalyStrap\Customizer;

use ItalyStrap\Config\AlignmentChoicesTrait;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Config\ConfigThemeProvider;

class NavbarFields {

	use AlignmentChoicesTrait;

	private \WP_Customize_Manager $manager;
	private ConfigInterface $config;
	private FieldControlFactory $factory;

	public function __construct(
		\WP_Customize_Manager $manager,
		ConfigInterface $config,
		FieldControlFactory $factory
	) {
		$this->manager = $manager;
		$this->config = $config;
		$this->factory = $factory;
	}

	public function __invoke(): void {
		$prefix = $this->config->get(ConfigThemeProvider::PREFIX);

		$this->manager->add_section(
			self::class,
			[
				'title'			=> \__( 'Navbar Settings', 'italystrap' ), // Visible title of section.
				'panel'			=> PanelFields::class,
				// phpcs:disable
				'description'	=> \__( 'Allows you to customize settings for the main navbar. Remember that this uses the Twitter Bootstrap Navbar style, if you want more info read the <a href="http://getbootstrap.com/components/#navbar" target="_blank">documentation</a>.', 'italystrap' ),
				// phpcs:enabl
				'description_hidden'	=> true,
			]
		);

		$this->manager->add_setting(
			'navbar[type]',
			[
				'default'			=> $this->config->get('navbar.type'),
				'type'				=> 'theme_mod',
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'sanitize_text_field',
			]
		);

		$this->manager->add_control(
			'italystrap_navbar[type]',
			[
				'settings'	=> 'navbar[type]',
				'label'			=> \__( 'Navbar color mode', 'italystrap' ),
				'description'	=> \__( 'Select the color mode of the navbar.', 'italystrap' ),
				'section'		=> self::class,
				'type'			=> 'radio',
				'choices'		=> [
					'navbar-default'	=> \__( 'Light mode', 'italystrap' ),
					'navbar-inverse'	=> \__( 'Dark mode', 'italystrap' ),
				],
			]
		);

		$this->manager->add_setting(
			'navbar[position]',
			['default'			=> $this->config->get('navbar.position'), 'type'				=> 'theme_mod', 'transport'			=> 'postMessage', 'sanitize_callback'	=> 'sanitize_text_field']
		);

		$this->manager->add_control(
			'italystrap_navbar[position]',
			[
				'settings'	=> 'navbar[position]',
				'label'			=> \__( 'Navbar vertical position', 'italystrap' ),
				// phpcs:disable
				'description'	=> \__( 'Select the position of the navbar. By default is set to "relative top", you can chose "fixed top", "fixed bottom" or "static top", with the "static top" you also have to set the navbar "full width" for fixing the correct padding.', 'italystrap' ),
				// phpcs:enable
				'section'		=> self::class,
				'type'			=> 'radio',
				'choices'		=> [
					'navbar-relative-top'	=> \__( 'Default relative top', 'italystrap' ),
					'navbar-static-top'		=> \__( 'Static Top', 'italystrap' ),
					'navbar-fixed-top'		=> \__( 'Fixed Top', 'italystrap' ),
					'navbar-fixed-bottom'	=> \__( 'Fixed Bottom', 'italystrap' ),
				],
			]
		);

		$this->manager->add_setting(
			'navbar[nav_width]',
			[
				'default'			=> $this->config->get('navbar.nav_width'),
				'type'				=> 'theme_mod',
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'sanitize_text_field'
			]
		);
		$this->manager->add_control(
			'italystrap_navbar[nav_width]',
			[
				'settings'	=> 'navbar[nav_width]',
				'label'			=> \__( 'Navbar width', 'italystrap' ),
				// phpcs:disable
				'description'	=> \__( 'Select the nav_width of navbar, this enlarges the navbar to the windows size (use it also width Static Top option).', 'italystrap' ),
				// phpcs:enable
				'section'		=> self::class,
				'type'			=> 'radio',
				'choices'		=> [
					'container'	=> \__( 'Boxed', 'italystrap' ),
					'none'		=> \__( 'Full width', 'italystrap' ),
				],
			]
		);

		/**
		 * Select the menus_width of navbar
		 */
		$this->manager->add_setting(
			'navbar[menus_width]',
			[
				'default'			=> $this->config->get('navbar.menus_width'),
				'type'				=> 'theme_mod',
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'sanitize_text_field'
			]
		);
		$this->manager->add_control(
			'italystrap_navbar[menus_width]',
			[
				'settings'	=> 'navbar[menus_width]',
				'label'			=> \__( 'Navbar menus width', 'italystrap' ),
				// phpcs:disable
				'description'	=> \__( 'Select the menus_width, this is the width of the container of the 2 menu, main-menu and secondary-menu, with the full width the menus will enlarge to the widnows size, with the "width of the content" they will sized like the size of the content. If you have select the "default boxed width" leave the default value.', 'italystrap' ),
				// phpcs:enable
				'section'		=> self::class,
				'type'			=> 'radio',
				'choices'		=> $this->getHorizontalStandard(),
				//		'active_callback'	=> function ( $control ) {
				//			return $control->manager->get_setting('navbar[nav_width]')->value() == 'none';
				//		},
			]
		);

		$this->manager->add_setting(
			'navbar[main_menu_x_align]',
			[
				'default'			=> $this->config->get('navbar.main_menu_x_align'),
				'type'				=> 'theme_mod',
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'sanitize_text_field'
			]
		);
		$this->manager->add_control(
			'italystrap_navbar[main_menu_x_align]',
			[
				'settings'	=> 'navbar[main_menu_x_align]',
				'label'			=> \__( 'Main menu align', 'italystrap' ),
				'description'	=> \__( 'Select the main menu alignment', 'italystrap' ),
				'section'		=> self::class,
				'type'			=> 'radio',
				'choices'		=> [
					'navbar-left'	=> \__( 'Left', 'italystrap' ),
					'navbar-right'	=> \__( 'Right', 'italystrap' ),
				],
			]
		);
	}
}
