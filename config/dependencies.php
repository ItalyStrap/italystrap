<?php

namespace ItalyStrap;

/**
 * Injector from ACM if is active
 */
$injector = apply_filters( 'italystrap_injector', null );

return [

	/**
	 |-----------------------------------------------------------
	 | Autoload Shared Classes
	 |
	 | string|object
	 |-----------------------------------------------------------
	 */
	'sharing'				=> [
		'ItalyStrap\Css\Css',
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
		 'ItalyStrap\Config\Config_Interface'	=> 'ItalyStrap\Config\Config',
	],

	/**
	 * =============================
	 *
	 * Autoload Classes definitions
	 *
	 * ':var_name'	=> string,
	 * '+var_name'	=> invocable,
	 * 'walker'		=> 'ItalyStrap\Navbar\Bootstrap_Nav_Menu',
	 * ':walker'	=> new \ItalyStrap\Navbar\Bootstrap_Nav_Menu(),
	 * '+walker'	=> function () {
	 * 		return new \ItalyStrap\Navbar\Bootstrap_Nav_Menu();
	 * },
	 *
	 * ============================
	 */
	'definitions'			=> [
		'ItalyStrap\Navbar\Navbar'	=> [
			'walker' => 'ItalyStrap\Navbar\Bootstrap_Nav_Menu'
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
		'theme_mods'	=> $injector->make( '\ItalyStrap\Config\Config' )->all(),
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
		'ItalyStrap\Router\Router',
		// 'ItalyStrap\Core\Router\Controller', // Da testare meglio
		'ItalyStrap\Customizer\Theme_Customizer',
		'ItalyStrap\Css\Css',
		'ItalyStrap\Init\Init_Theme', // 'italystrap_plugin_app_loaded'
		'ItalyStrap\Custom\Sidebars\Sidebars',
		'ItalyStrap\Nav_Menu\Register_Nav_Menu_Edit',
		'ItalyStrap\Custom\Image\Size', // 'italystrap_plugin_app_loaded'
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