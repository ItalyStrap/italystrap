<?php
declare(strict_types=1);

namespace ItalyStrap\Customizer;

class BreadcrumsFields {

	private \WP_Customize_Manager $manager;
	private FieldControlFactory $control;
	private \WP_Theme $theme;

	public function __construct(
		\WP_Customize_Manager $manager,
		FieldControlFactory $control,
		\WP_Theme $theme
	) {
		$this->manager = $manager;
		$this->control = $control;
		$this->theme = $theme;
	}

	public function __invoke(): void {

		if ( ! class_exists( '\ItalyStrap\Customizer\Control\Multicheck' ) ) {
			return;
		}

		$id = 'italystrap';

		$this->manager->add_section(
			self::class,
			[
				'title'			=> \__( 'Breadcrumbs', 'italystrap' ),
				'panel'			=> PanelFields::class,
				'description'	=> \__( 'Allows you to show the breadcrumbs on selected templates.', 'italystrap' ),
			]
		);

		$id_breadcrumbs = 'breadcrumbs_show_on';
		$this->manager->add_setting(
			$id_breadcrumbs,
			[
				'type'				=> 'theme_mod',
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'sanitize_text_field',
			]
		);

		$this->manager->add_control(
			$this->control->make(
				'\ItalyStrap\Customizer\Control\Multicheck',
				$this->manager,
				"{$id}_{$id_breadcrumbs}",
				[
					'label'		=> \__( 'Display breadcrumbs on', 'italystrap' ),
					'section'	=> self::class,
					'type'		=> 'multicheck',
					'settings'	=> $id_breadcrumbs,
					'choices'	=> \array_merge(
						[
							'404.php'			=> \__( '404', 'italystrap' ),
							'archive.php'		=> \__( 'Archive', 'italystrap' ),
							'author.php'		=> \__( 'Author', 'italystrap' ),
							'front-page.php'	=> \__( 'Front page', 'italystrap' ),
							'home.php'			=> \__( 'Home', 'italystrap' ),
							'page.php'			=> \__( 'Page', 'italystrap' ),
							'search.php'		=> \__( 'Search', 'italystrap' ),
							'single.php'		=> \__( 'Single', 'italystrap' ),
						],
						$this->theme->get_page_templates()
					),
				]
			)
		);
	}
}
