<?php

namespace ItalyStrap;

use ItalyStrap\Config\Config;
use ItalyStrap\Factory;

global $wp_query;

return [

	/**
	 |-----------------------------------------------------------
	 | Autoload Shared Classes
	 |
	 | string|object
	 |-----------------------------------------------------------
	 */
	'sharing'				=> [
		'\ItalyStrap\Config\Config',
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
		 '\ItalyStrap\Config\Config_Interface'	=> '\ItalyStrap\Config\Config',
		 '\Walker_Nav_Menu'						=> '\ItalyStrap\Navbar\Bootstrap_Nav_Menu',
	],

	/**
	 * =============================
	 *
	 * Autoload Classes definitions
	 *
	 * 'walker'		=> 'ItalyStrap\Navbar\Bootstrap_Nav_Menu',
	 * ':walker'	=> new \ItalyStrap\Navbar\Bootstrap_Nav_Menu(),
	 * '+walker'	=> function () {
	 * 		return new \ItalyStrap\Navbar\Bootstrap_Nav_Menu();
	 * },
	 *
	 * ============================
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
			':config'	=> new Config( \ItalyStrap\Config\get_config_file_content( 'pagination' ) ),
		],
		'\ItalyStrap\Components\Navigations\Pager'	=> [
			':config'	=> new Config( \ItalyStrap\Config\get_config_file_content( 'pager' ) ),
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
		'theme_mods'	=> Factory\get_config()->all(),
		'wp_query'		=> $wp_query,
		'query'			=> $wp_query,
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
//		'MyClass'	=> function( $myObj, $injector ) {
//			d( $myObj, $injector );
//			$myObj->myProperty = 42;
//		},
	],

	/**
	 * ========================================================================
	 *
	 * Autoload Concrete Classes
	 * Loaded on admin and front-end
	 *
	 * string
	 *
	 * ========================================================================
	 */
	'concretes'				=> [
		'\ItalyStrap\Router\Router',
		// '\ItalyStrap\Core\Router\Controller', // Da testare meglio
		'\ItalyStrap\Customizer\Theme_Customizer',
		'\ItalyStrap\Css\Css',
		'\ItalyStrap\Init\Init_Theme', // 'italystrap_plugin_app_loaded'
		'\ItalyStrap\Custom\Sidebars\Sidebars',
		'\ItalyStrap\Nav_Menu\Register_Nav_Menu_Edit',
		'\ItalyStrap\Custom\Image\Size', // 'italystrap_plugin_app_loaded'
	],

//	'options_concretes'		=> [],
//	'subscribers'			=> [],
	'execute'				=> [
//		[
//			function () {},
//			[],
//		],
//		function () { echo '<h1>Callable</h1>'; },
	],
];