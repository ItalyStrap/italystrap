<?php
declare(strict_types=1);

namespace ItalyStrap\Config;

class ConfigMiscProvider {

	private ConfigInterface $config;

	public function __construct(ConfigInterface $config) {
		$this->config = $config;
	}

	public function __invoke(): iterable {
		return [
			'custom_header'					=> [
				'container_width'	=> 'container',
			],

//			'custom_css'					=> '',

			/**
			 * ==========================================================
			 *
			 * Navbar
			 *
			 * ==========================================================
			 */
			'navbar'						=> [
				/**
				 * options:
				 * navbar-default
				 * navbar-inverse
				 */
				'type'			=> 'navbar-inverse',
				'position'		=> 'navbar-static-top',
				'nav_width'		=> 'none', // This is the container of entire navbar.
				'menus_width'	=> 'container', // This is the container of the 2 menus inside the nav container
				//and the navbar_header brand and toggle.
				'main_menu_x_align'	=> 'navbar-left',
			],

			/**
			 * Layout configuration
			 * It's still in alpha version
			 */
		//		'site_layout'					=> 'content_sidebar',
			//( is_customize_preview() ? get_theme_mod('site_layout') : $this->theme_mods['site_layout'] );
			// https://core.trac.wordpress.org/ticket/24844
			'site_layout'					=> (string) \apply_filters( 'theme_mod_site_layout', 'content_sidebar' ),
			'singular_layout'				=> 'content_sidebar',

			'container_width'				=> 'container', // container-fluid.
			'container_class'				=> 'container', // container-fluid. // @TODO maybe not used
			'content_class'					=> 'col-md-8', // 7 - 6.
			'sidebar_class'					=> 'col-md-4', // 3 - 3.
			'sidebar_secondary_class'		=> '', // 2 - 3.
			'full_width'					=> 'col-md-12',

			'layout'						=> [
				'choices'	=> [
					// 'none'				=> \__( 'None', 'italystrap' ),
					'container-fluid'	=> \__( 'Full witdh', 'italystrap' ),
					'container'			=> \__( 'Standard width', 'italystrap' ),
				]
			],

			'post_content_template'			=> '',
			'breadcrumbs_show_on'			=> '',
		];
	}
}
