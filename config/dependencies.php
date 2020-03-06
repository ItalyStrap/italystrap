<?php
declare(strict_types=1);
namespace ItalyStrap;

use Auryn\Injector;
use ItalyStrap\Asset\Script;
use ItalyStrap\Asset\Style;
use ItalyStrap\Builders\Builder_Interface;
use ItalyStrap\Config\{Config, Config_Interface, ConfigFactory, ConfigInterface};
use ItalyStrap\Empress\AurynResolver;
use ItalyStrap\Event\EventDispatcher;
use ItalyStrap\Event\EventResolverExtension;
use ItalyStrap\Event\EventDispatcherInterface;
use ItalyStrap\Event\SubscriberRegister;
use ItalyStrap\Event\SubscriberRegisterInterface;
use ItalyStrap\HTML\Attributes;
use ItalyStrap\HTML\Tag;
use ItalyStrap\Theme\{Assets, NavMenus, Sidebars, Support, TextDomain, Thumbnails, TypeSupport};
use ItalyStrap\View\{ViewFinderInterface, ViewInterface};
use Walker_Nav_Menu;
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
	AurynResolver::SHARING				=> [
		EventDispatcherInterface::class,
		SubscriberRegisterInterface::class,

		/**
		 * Make sure the config is shared.
		 * Already shared in bootstrap.php or in ACM if is active.
		 */
		Config::class,

		View\View::class,
		Attributes::class,
		Tag::class,
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
	AurynResolver::ALIASES				=> [
		EventDispatcherInterface::class		=> EventDispatcher::class,
		SubscriberRegisterInterface::class	=> SubscriberRegister::class,

		ConfigInterface::class				=> Config::class,
		Config_Interface::class				=> Config::class,

		ViewFinderInterface::class			=> View\ViewFinder::class,
		ViewInterface::class				=> View\View::class,
		Walker_Nav_Menu::class				=> Navbar\Bootstrap_Nav_Menu::class,
		Builder_Interface::class			=> Builders\Builder::class,
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
	AurynResolver::DEFINITIONS			=> [

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
	AurynResolver::DEFINE_PARAM			=> [
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
	AurynResolver::DELEGATIONS			=> [],

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
	AurynResolver::PREPARATIONS			=> [
		Theme\Assets::class		=> function ( Theme\Assets $assets, Injector $injector ) {

			$event_dispatcher = $injector->make(EventDispatcher::class);

			$loaded = false;
			$event_dispatcher->addListener('wp_enqueue_scripts', function () use ($assets, &$loaded) {
				$loaded = true;
				$assets->withAssets(
					new Style( ConfigFactory::make( get_config_file_content('theme/styles') ) ),
					new Script( ConfigFactory::make( get_config_file_content('theme/scripts') ) )
				);
			}, 1);

			$event_dispatcher->addListener('shutdown', function () use (&$loaded){
				if ( ! $loaded && \function_exists( 'debug' ) ) {
					\debug(\sprintf(
						'Assets are not loaded properly, called in: %s',
						__FILE__
					));
				}
			});
		},

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
	 * If you use key => value pair make sure to bind the key with an option name
	 * to activate or deactivate the service from an option panel.
	 *
	 * ========================================================================
	 */
	EventResolverExtension::SUBSCRIBERS				=> [

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
