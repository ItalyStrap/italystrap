<?php

namespace ItalyStrap;

/**
 * Injector from ACM if is active
 */
$injector = apply_filters( 'italystrap_injector', null );

return [

	/**
	 |---------------------------
	 | Autoload Shared Classes
	 |
	 | string|object
	 |---------------------------
	 */
	'sharing'				=> [
		'ItalyStrap\Css\Css',
	],

	/**
	 * ======================
	 * Autoload Aliases Class
	 *
	 * string
	 * ======================
	 */
	'aliases'				=> [
		// 'ItalyStrap\Config\Config_Interface'	=> 'ItalyStrap\Config\Config',
	],

	/**
	 * =============================
	 * Autoload Classes definitions
	 *
	 * ':var_name'	=> string
	 * '+var_name'	=> invocable
	 * 'walker'		=> 'ItalyStrap\Navbar\Bootstrap_Nav_Menu'
	 * ':walker'	=> new \ItalyStrap\Navbar\Bootstrap_Nav_Menu()
	 * '+walker'	=> function () {
	 * 		return new \ItalyStrap\Navbar\Bootstrap_Nav_Menu();
	 * }
	 * ============================
	 */
	'definitions'			=> [
		'ItalyStrap\Navbar\Navbar'	=> [
			'walker' => 'ItalyStrap\Navbar\Bootstrap_Nav_Menu'
		],
	],

	'define_param'			=> [
//		'theme_mods'	=> $theme_mods,
		'theme_mods'	=> $injector->make( '\ItalyStrap\Config\Config' )->all(),
	],

	'delegations'			=> [],
	'preparations'			=> [],

	/**
	 * ========================================================================
	 * Autoload Concrete Classes
	 * ========================================================================
	 */
	'concretes'				=> [

	],

	'options_concretes'		=> [],
	'subscribers'			=> [],
	'execute'				=> [
//		[
//			function () {},
//			[],
//		],
//		function () { echo '<h1>Callable</h1>'; },
	],
];