<?php

namespace ItalyStrap;

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
		 * Already shared in bootstrap.php or in ACM if active
		 */
		'\ItalyStrap\Config\Config',
		'\ItalyStrap\Event\Manager',
		'\ItalyStrap\Template\View',
		'\ItalyStrap\Css\Css',
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
		'\ItalyStrap\Config\Config_Interface'		=> '\ItalyStrap\Config\Config',
		'\ItalyStrap\Template\Finder_Interface'		=> '\ItalyStrap\Template\Finder',
		'\ItalyStrap\Template\View_Interface'		=> '\ItalyStrap\Template\View',
		'\Walker_Nav_Menu'							=> '\ItalyStrap\Navbar\Bootstrap_Nav_Menu',
		'\ItalyStrap\Builders\Builder_Interface'	=> '\ItalyStrap\Builders\Builder',
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
//		'\ItalyStrap\Navbar\Navbar'	=> [
//			'walker' => '\ItalyStrap\Navbar\Bootstrap_Nav_Menu'
//		],
		'\ItalyStrap\Navbar\Navbar'	=> [
			':fallback_cb' => '\ItalyStrap\Navbar\Bootstrap_Nav_Menu::fallback',
		],
//		'\ItalyStrap\Navbar\Navbar'	=> [
//			':fallback_cb' => [ '\ItalyStrap\Navbar\Bootstrap_Nav_Menu', 'fallback' ],
//		],
		'\ItalyStrap\Components\Navigations\Pagination'	=> [
			':config'	=> Config_Factory::make( get_config_file_content( 'pagination' ) ),
		],
		'\ItalyStrap\Components\Navigations\Pager'	=> [
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
		Builders\Builder::class	=> function( Builders\Builder $builder, \Auryn\Injector $injector ) {
			$builder->set_injector( $injector );
		},
		Template\Finder::class	=> function( Template\Finder $finder ) {
			$finder->in( get_config()->get( 'template_dir' ) );
		},
	],

	/**
	 * ========================================================================
	 *
	 * Autoload Concrete Classes
	 * Loaded on admin and front-end
	 * @TODO Maybe it should be called subscribers because they are subscribed and not only instantiated
	 *
	 * string
	 *
	 * ========================================================================
	 */
	'concretes'				=> [
//		'\ItalyStrap\Router\Router', // Anche questo da testare meglio
		// '\ItalyStrap\Core\Router\Controller', // Da testare meglio
		Customizer\Theme_Customizer::class,
		Css\Css::class,
		Init\Init_Theme::class,
		Custom\Sidebars\Sidebars::class,
		Custom\Image\Size::class,
		Nav_Menu\Register_Nav_Menu_Edit::class,

		// This is the class that build the page
		Builders\Director::class,
	],

//	'subscribers'			=> [],
];