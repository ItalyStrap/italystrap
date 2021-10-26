<?php
declare(strict_types=1);
namespace ItalyStrap;

use Auryn\Injector;
use ItalyStrap\Asset\AssetManager;
use ItalyStrap\Asset\ConfigBuilder;
use ItalyStrap\Asset\Debug\DebugScript;
use ItalyStrap\Asset\Debug\DebugStyle;
use ItalyStrap\Asset\Loader\GeneratorLoader;
use ItalyStrap\Asset\Script;
use ItalyStrap\Asset\Style;
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
use function ItalyStrap\Config\get_config_file_content;
use function ItalyStrap\Config\get_config_file_content_last;
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
//		Config_Interface::class				=> Config::class,

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

//		SidebarsSubscriber::class	=> [
//			 ':config'	=> ConfigFactory::make( get_config_file_content( 'theme/sidebars' ) ),
//		],
		SidebarsSubscriber::class	=> [
			 '+config'	=> function () {
				return ConfigFactory::make( get_config_file_content( 'theme/sidebars' ) );
			 },
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

		Builders\Builder::class	=> [
			':config'	=> ConfigFactory::make( get_config_file_content( 'structure' ) ),
		],

		Components\Navigations\Navbar::class	=> [
			':fallback_cb' => [ Navbar\BootstrapNavMenu::class, 'fallback' ],
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
	AurynConfig::DEFINE_PARAM			=> [
//		':theme_mods'	=> function () : array {
//			return get_config()->all();
//		},
		'theme_mods'	=> get_config()->all(),
		':wp_query'		=> function (): \WP_Query {
			global $wp_query;
			return $wp_query;
		},
		':query'			=> function (): \WP_Query {
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
		AssetManager::class			=> function ( AssetManager $manager, Injector $injector ) {

			/** @var EventDispatcher $event_dispatcher */
			$event_dispatcher = $injector->make(EventDispatcher::class);

			$experimental_assets_path_generator = function ( string $dir ): array {
				$sub_dir = ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) ? 'src/' :  '';

				return \array_unique(
					[
						STYLESHEETPATH . '/assets/' . $dir,
						STYLESHEETPATH . '/' . $dir, // This is added for avoid BC breaks
						STYLESHEETPATH . '/' . $dir . $sub_dir, // This is added for avoid BC breaks
						TEMPLATEPATH . '/assets/' . $dir,
					]
				);
			};

			$css_finder = ( new FinderFactory() )->make()
				->in( $experimental_assets_path_generator('css/') );

			$js_finder = ( new FinderFactory() )->make()
				->in( $experimental_assets_path_generator('js/') );

			$injector->defineParam('base_url', \get_option( 'siteurl' ) . '/');
			$injector->defineParam('base_path', ABSPATH);

			/** @var ConfigBuilder $config_builder */
			$config_builder = $injector->make( ConfigBuilder::class );

			$config_builder->withType(
				Style::EXTENSION,
				\ItalyStrap\Core\is_debug() ? DebugStyle::class : Style::class
			);
			$config_builder->withFinderForType( Style::EXTENSION, $css_finder);

			$config_builder->withType(
				Script::EXTENSION,
				\ItalyStrap\Core\is_debug() ? DebugScript::class : Script::class
			);
			$config_builder->withFinderForType( Script::EXTENSION, $js_finder);

			/**
			 * @todo Maybe I can add a check for forcing child to load its own assets
			 * 		 is_child() ? [] : get_config_file_content_last( 'assets/[styles|scripts]' )
			 * 		 because assetss should not be loaded from parent by default.
			 * @var array<int, mixed>
			 */
			$styles = $event_dispatcher->filter(
				'italystrap_config_enqueue_style',
				get_config_file_content_last( 'assets/styles' )
			);

			/** @var array<int, mixed> $scripts */
			$scripts = $event_dispatcher->filter(
				'italystrap_config_enqueue_script',
				get_config_file_content_last( 'assets/scripts' )
			);

			$config_builder->addConfig( $styles );
			$config_builder->addConfig( $scripts );

			$asset_loader = $injector->make( GeneratorLoader::class );
			$assets = $asset_loader->load( $config_builder->parseConfig() );

			$manager->withAssets(...$assets);

//			$event_dispatcher->addListener('shutdown', function () use ( $assets ){
//				/** @var AssetInterface $asset */
//				foreach ( $assets as $asset ) {
//					d( $asset->handle() );
//					d( $asset->isEnqueued() );
//					d( $asset->isRegistered() );
//				}
//			});

//			if ( \ItalyStrap\Core\is_debug() ) {
//				$event_dispatcher->addListener(
//					\Inpsyde\Assets\AssetManager::ACTION_SETUP,
//					function (
//						\Inpsyde\Assets\AssetManager $asset_manager
//					) use ($config_builder) {
////						'type'		=> \Inpsyde\Assets\Style::class
////						$loader = new \ItalyStrap\Asset\Adapters\InpsydeGeneratorLoader();
////						$assets = $loader->load( $config_builder->parsedConfig() );
////						$asset_manager->register( $assets );
//					}
//				);
//			}
		},

		Builders\Builder::class	=> function ( Builders\Builder $builder, Injector $injector ) {
			$builder->setInjector( $injector );
		},

		Finder::class	=> function ( FinderInterface $finder, Injector $injector ) {
			$config = $injector->make(ConfigInterface::class );

			$dirs = [
				$config->get('CHILDPATH') . '/' . $config->get('template_dir'),
				$config->get('PARENTPATH') . '/' . $config->get('template_dir'),
			];

			$finder->in( $dirs );
		},
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

		\ItalyStrap\Experimental\CommentHelperSubscriber::class,
		\ItalyStrap\Experimental\ExperimentalCustomizerOptionWithAndPosition::class,
		\ItalyStrap\Experimental\OembedWrapper::class,

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
	],
];
