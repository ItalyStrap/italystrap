<?php
declare(strict_types=1);
namespace ItalyStrap;

use Auryn\Injector;
use ItalyStrap\Asset\AssetManager;
use ItalyStrap\Asset\ExperimentalAssetPreparator;
use ItalyStrap\Asset\EditorSubscriber;
use ItalyStrap\Builders\BuilderInterface;
use ItalyStrap\Config\Config;
use ItalyStrap\Config\ConfigFactory;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Empress\AurynConfig;
use ItalyStrap\Event\EventDispatcher;
use ItalyStrap\Event\EventDispatcherInterface;
use ItalyStrap\Event\SubscriberRegister;
use ItalyStrap\Event\SubscriberRegisterInterface;
use ItalyStrap\Event\SubscribersConfigExtension;
use ItalyStrap\Experimental\ExperimentalCustomizerOptionWithAndPosition;
use ItalyStrap\Experimental\OembedWrapper;
use ItalyStrap\Finder\FileInfoFactory;
use ItalyStrap\Finder\FileInfoFactoryInterface;
use ItalyStrap\Finder\FilesHierarchyIterator;
use ItalyStrap\Finder\Finder;
use ItalyStrap\Finder\FinderFactory;
use ItalyStrap\Finder\FinderInterface;
use ItalyStrap\Finder\SearchFileStrategy;
use ItalyStrap\HTML\Attributes;
use ItalyStrap\HTML\AttributesInterface;
use ItalyStrap\HTML\Tag;
use ItalyStrap\Asset\AssetsSubscriber;
use ItalyStrap\Theme\NavMenusSubscriber;
use ItalyStrap\Theme\SidebarsSubscriber;
use ItalyStrap\Theme\SupportSubscriber;
use ItalyStrap\Theme\TextDomainSubscriber;
use ItalyStrap\Theme\ThumbnailsSubscriber;
use ItalyStrap\Theme\PostTypeSupportSubscriber;
use ItalyStrap\HTML\TagInterface;
use ItalyStrap\View\ViewInterface;
use Walker_Nav_Menu;
use WP_Query;
use function ItalyStrap\Config\get_config_file_content;
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
	AurynConfig::SHARING				=> [
		EventDispatcher::class,
		SubscriberRegister::class,

		/**
		 * Make sure the config is shared.
		 * Already shared in bootstrap.php or in ACM if is active.
		 */
		Config::class,

		Attributes::class,
		Tag::class,
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
	AurynConfig::ALIASES				=> [
		EventDispatcherInterface::class		=> EventDispatcher::class,
		SubscriberRegisterInterface::class	=> SubscriberRegister::class,

		ConfigInterface::class				=> Config::class,

		AttributesInterface::class			=> Attributes::class,
		TagInterface::class					=> Tag::class,

		FileInfoFactoryInterface::class		=> FileInfoFactory::class,
		SearchFileStrategy::class			=> FilesHierarchyIterator::class,
		FinderInterface::class				=> Finder::class,

		ViewInterface::class				=> View\View::class,
		Walker_Nav_Menu::class				=> Navbar\BootstrapNavMenu::class,
		BuilderInterface::class				=> Builders\Builder::class,
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
	AurynConfig::DEFINITIONS			=> [

		SidebarsSubscriber::class	=> [
			 ':config'	=> ConfigFactory::make( get_config_file_content( 'theme/sidebars' ) ),
		],
		ThumbnailsSubscriber::class	=> [
			':config'	=> ConfigFactory::make( get_config_file_content( 'theme/thumbnails' ) ),
		],
		SupportSubscriber::class	=> [
			':config'	=> ConfigFactory::make( get_config_file_content( 'theme/supports' ) ),
		],
		PostTypeSupportSubscriber::class	=> [
			':config'	=> ConfigFactory::make( get_config_file_content( 'theme/type-supports' ) ),
		],
		NavMenusSubscriber::class	=> [
			':config'	=> ConfigFactory::make( get_config_file_content( 'theme/nav-menus' ) ),
		],

//		Builders\ParseAttr::class	=> [
//			':config'	=> ConfigFactory::make(
//				array_replace_recursive(
//					get_config_file_content( 'html_attrs' ),
//					get_config_file_content( 'schema' )
//				)
//			),
//		],

		EditorSubscriber::class => [
			'+finder'	=> static function () {
				$injector = \ItalyStrap\Factory\injector();
				$config = $injector->make( ConfigInterface::class );
				$finder =  $injector->make( FinderInterface::class )
					->in( [
						$config->get('CHILDPATH') . '/assets/',
						$config->get('PARENTPATH') . '/assets/',
					] );

				$finder->names([
					'../css/editor-style.css',
					'../assets/css/editor-style.css',
				]);

				return $finder;
			},
		],

		Builders\Builder::class	=> [
			'+view'	=> static function (): ViewInterface {
				$injector = \ItalyStrap\Factory\injector();
				$config = $injector->make( ConfigInterface::class );

				$finder = $injector->make( FinderInterface::class )
					->in( [
						$config->get('CHILDPATH') . '/' . $config->get('template_dir'),
						$config->get('PARENTPATH') . '/' . $config->get('template_dir'),
					] );

				return $injector->make( ViewInterface::class, [ ':finder' => $finder ] );
			},
			':config'	=> ConfigFactory::make( get_config_file_content( 'structure' ) ),
		],

		Components\Navigations\Navbar::class	=> [
			':fallback_cb' => [ Navbar\BootstrapNavMenu::class, 'fallback' ],
		],
		Components\Navigations\Pagination::class	=> [
			':config'	=> ConfigFactory::make( get_config_file_content( 'components/pagination' ) ),
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
	AurynConfig::DEFINE_PARAM			=> [
		'theme_mods'	=> get_config()->all(),
		':wp_query'		=> static function (): WP_Query {
			global $wp_query;
			return $wp_query;
		},
		':query'			=> static function (): WP_Query {
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
	AurynConfig::DELEGATIONS			=> [],

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
	AurynConfig::PREPARATIONS			=> [

		/**
		 * This class is lazy loaded
		 */
		AssetManager::class			=> new ExperimentalAssetPreparator(),

//		Builders\Builder::class	=> static function ( Builders\Builder $builder, Injector $injector ) {
//			$builder->setInjector( $injector );
//		},
	],

	/**
	 * ========================================================================
	 *
	 * Lazyload Classes
	 * Loaded on admin and front-end
	 *
	 * Useful if you need to load lazily your classes, for example
	 * if you want classes are loaded only when are really needed.
	 *
	 * ========================================================================
	 */
	AurynConfig::PROXY					=> [
		AssetManager::class,
//		SidebarsSubscriber::class,
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
	SubscribersConfigExtension::SUBSCRIBERS				=> [

		ExperimentalCustomizerOptionWithAndPosition::class,
		OembedWrapper::class,

		/**
		 * Register Theme stuff
		 */
		NavMenusSubscriber::class,
		SidebarsSubscriber::class,
		SupportSubscriber::class,
		TextDomainSubscriber::class,
		ThumbnailsSubscriber::class,
		PostTypeSupportSubscriber::class,


		Custom\Metabox\Register::class,

		Admin\Nav_Menu\ItemCustomFields::class,
		Customizer\ThemeCustomizer::class,
		Css\CssSubscriber::class,

		// This is the class that build the page
		Builders\Director::class,

		/**
		 * With this class I can lazyload the AssetManager::class
		 * see above in the PROXY config.
		 */
		AssetsSubscriber::class,
		Asset\EditorSubscriber::class,
	],
];
