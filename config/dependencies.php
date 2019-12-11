<?php
declare(strict_types=1);
namespace ItalyStrap;

use Auryn\Injector;
use ItalyStrap\Builders\Builder_Interface;
use ItalyStrap\Config\{Config, ConfigFactory, ConfigInterface};
use ItalyStrap\Theme\{NavMenus, Sidebars, Support, TextDomain, Thumbnails, TypeSupport};
use ItalyStrap\View\{ViewFinderInterface, ViewInterface};
use function ItalyStrap\Config\{get_config_file_content};
use function ItalyStrap\Factory\get_config;

return [

	/**
	 * ==========================================================
	 *
	 * Autoload Shared Classes
	 *
	 * string|object
	 *
	 * ==========================================================
	 */
	'sharing'				=> [

		/**
		 * Make sure the config is shared.
		 * Already shared in bootstrap.php or in ACM if is active.
		 */
		Config::class,
		Event\Manager::class,
		View\View::class,
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
		ConfigInterface::class		=> Config::class,
		ViewFinderInterface::class	=> View\ViewFinder::class,
		ViewInterface::class		=> View\View::class,
		\Walker_Nav_Menu::class		=> Navbar\Bootstrap_Nav_Menu::class,
		Builder_Interface::class	=> Builders\Builder::class,
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

		Theme\Sidebars::class	=> [
			 ':config'	=> ConfigFactory::make( get_config_file_content( 'theme/sidebars' ) ),
		],
		Theme\Thumbnails::class	=> [
			':config'	=> ConfigFactory::make( get_config_file_content( 'theme/thumbnails' ) ),
		],
		Theme\Support::class	=> [
			':config'	=> ConfigFactory::make( get_config_file_content( 'theme/supports' ) ),
		],
		Theme\TypeSupport::class	=> [
			':config'	=> ConfigFactory::make( get_config_file_content( 'theme/type-supports' ) ),
		],
		Theme\NavMenus::class	=> [
			':config'	=> ConfigFactory::make( get_config_file_content( 'theme/nav-menus' ) ),
		],

		Builders\Builder::class	=> [
			':config'	=> ConfigFactory::make( get_config_file_content( 'structure' ) ),
		],

//		Builders\Parse_Attr::class	=> [
//			':config'	=> Config_Factory::make(
//				array_replace_recursive(
//					get_config_file_content( 'html_attrs' ),
//					get_config_file_content( 'schema' )
//				)
//			),
//		],

		Components\Navigations\Navbar::class	=> [
			':fallback_cb' => [ Navbar\Bootstrap_Nav_Menu::class, 'fallback' ],
		],
		Components\Navigations\Pagination::class	=> [
			':config'	=> ConfigFactory::make( get_config_file_content( 'components/pagination' ) ),
		],
		Components\Navigations\Pager::class	=> [
			':config'	=> ConfigFactory::make( get_config_file_content( 'components/pager' ) ),
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
		':wp_query'		=> function (): \WP_Query {
			global $wp_query;
			return $wp_query;
		},
		':query'			=> function (): \WP_Query  {
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
		Builders\Builder::class	=> function( Builders\Builder $builder, Injector $injector ) {
			$builder->set_injector( $injector );
		},
		View\ViewFinder::class	=> function( View\ViewFinderInterface $finder, Injector $injector ) {
			$config = get_config();

			$dirs = [
				$config->CHILDPATH . '/' . $config->template_dir,
				$config->PARENTPATH . '/' . $config->template_dir,
			];

			$finder->in( $dirs );
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

		/**
		 * Register Theme stuff
		 */
		NavMenus::class,
		Sidebars::class,
		Support::class,
		TextDomain::class,
		Thumbnails::class,
		TypeSupport::class,


		Custom\Metabox\Register::class,

		Admin\Nav_Menu\Item_Custom_Fields::class,
		Customizer\Theme_Customizer::class,
		Css\Css::class,
		User\Contact_Methods::class,

		// This is the class that build the page
		Builders\Director::class,
	],
];
