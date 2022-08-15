<?php
declare(strict_types=1);

namespace ItalyStrap\Config;

class ConfigNavigationProvider {

	public function __invoke(): iterable {
		return [
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
		];
	}
}
