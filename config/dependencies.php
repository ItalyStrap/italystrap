<?php

namespace ItalyStrap;

use ItalyStrap\Builders\Builder;
use ItalyStrap\Config\Config_Factory;
use function \ItalyStrap\Config\get_config_file_content;
use function \ItalyStrap\Factory\get_config;

return [

	/**
	 |-----------------------------------------------------------
	 | Autoload Shared Classes
	 |
	 | string|object
	 |-----------------------------------------------------------
	 */
	'sharing'				=> [
		/**
		 * Make sure the config is shared.
		 * Already shared in bootstrap.php or in ACM if is active.
		 */
		Config\Config::class,
		Event\Manager::class,
		Template\View::class,
	],

	/**
	 * ==========================================================
	 *
	 * Autoload Aliases Class
	 *
	 * string
	 *
	 * ==========================================================
	 */
	'aliases'				=> [
//		'\ItalyStrap\Config\Config_Interface'		=> Config\Config::class,
		'\ItalyStrap\Template\Finder_Interface'		=> Template\Finder::class,
		'\ItalyStrap\Template\View_Interface'		=> Template\View::class,
		'\Walker_Nav_Menu'							=> Navbar\Bootstrap_Nav_Menu::class,
		'\ItalyStrap\Builders\Builder_Interface'	=> Builders\Builder::class,
	],

	/**
	 * ==========================================================
	 *
	 * Autoload Classes definitions
	 *
	 * @example :
	 * 'walker'		=> 'ItalyStrap\Navbar\Bootstrap_Nav_Menu',
	 * ':walker'	=> new \ItalyStrap\Navbar\Bootstrap_Nav_Menu(),
	 * '+walker'	=> function () {
	 * 		return new \ItalyStrap\Navbar\Bootstrap_Nav_Menu();
	 * },
	 *
	 * ==========================================================
	 */
	'definitions'			=> [
		Builder::class	=> [
			':config'	=> Config_Factory::make( get_config_file_content( 'structure' ) ),
		],
		Components\Navigations\Navbar::class	=> [
			':fallback_cb' => [ Navbar\Bootstrap_Nav_Menu::class, 'fallback' ],
//			':fallback_cb' => '\ItalyStrap\Navbar\Bootstrap_Nav_Menu::fallback',
		],
		Components\Navigations\Pagination::class	=> [
			':config'	=> Config_Factory::make( get_config_file_content( 'pagination' ) ),
		],
		Components\Navigations\Pager::class	=> [
			':config'	=> Config_Factory::make( get_config_file_content( 'pager' ) ),
		],
	],

	/**
	 * ==========================================================
	 *
	 * Autoload Parameters Definitions
	 *
	 * string
	 *
	 * ==========================================================
	 */
	'define_param'			=> [
//		':theme_mods'	=> function () : array {
//			return get_config()->all();
//		},
		'theme_mods'	=> get_config()->all(),
		':wp_query'		=> function () {
			global $wp_query;
			return $wp_query;
		},
		':query'			=> function () {
			global $wp_query;
			return $wp_query;
		},
	],

	/**
	 * ========================================================================
	 *
	 * Autoload Delegates
	 * @link https://github.com/rdlowrey/auryn#instantiation-delegates
	 * 'MyComplexClass'	=> $complexClassFactory,
	 * 'SomeClassWithDelegatedInstantiation'	=> 'MyFactory',
	 * 'SomeClassWithDelegatedInstantiation'	=> 'MyFactory::factoryMethod'
	 *
	 * string
	 *
	 * ========================================================================
	 */
	'delegations'			=> [],

	/**
	 * ========================================================================
	 *
	 * Autoload Prepares
	 * @link https://github.com/rdlowrey/auryn#prepares-and-setter-injection
	 *
	 * string
	 *
	 * ========================================================================
	 */
	'preparations'			=> [
		Builder::class	=> function( Builder $builder, \Auryn\Injector $injector ) {
			$builder->set_injector( $injector );
		},
		Template\Finder::class	=> function( Template\Finder $finder ) {
			$finder->in( get_config()->get( 'template_dir' ) );
		},
	],

	/**
	 * ========================================================================
	 *
	 * Autoload Subscribers Classes
	 * Loaded on admin and front-end
	 *
	 * string
	 *
	 * ========================================================================
	 */
	'subscribers'				=> [
//		'\ItalyStrap\Router\Router', // Anche questo da testare meglio
		// '\ItalyStrap\Core\Router\Controller', // Da testare meglio
		Admin\Nav_Menu\Item_Custom_Fields::class,
		Customizer\Theme_Customizer::class,
		Css\Css::class,
		Init_Theme::class,
		Custom\Sidebars\Sidebars::class,
		Custom\Image\Size::class,
		User\Contact_Methods::class,

		// This is the class that build the page
		Builders\Director::class,
	],
];