<?php
declare(strict_types=1);
namespace ItalyStrap;

use Auryn\Injector;
use ItalyStrap\Asset\AssetManager;
use ItalyStrap\Asset\ExperimentalAssetPreparator;
use ItalyStrap\Asset\EditorSubscriber;
use ItalyStrap\Asset\InlineStyleSubscriber;
use ItalyStrap\Components\Breadcrumbs;
use ItalyStrap\Components\ComponentSubscriberExtension;
use ItalyStrap\Components\ArchiveAuthorInfo;
use ItalyStrap\Components\ArchiveHeadline;
use ItalyStrap\Components\AuthorInfo;
use ItalyStrap\Components\Colophon;
use ItalyStrap\Components\Comments;
use ItalyStrap\Components\Content;
use ItalyStrap\Components\CustomHeaderImage;
use ItalyStrap\Components\Entry;
use ItalyStrap\Components\EntryNone;
use ItalyStrap\Components\EntryNoneContent;
use ItalyStrap\Components\EntryNoneImage;
use ItalyStrap\Components\EntryNoneTitle;
use ItalyStrap\Components\Excerpt;
use ItalyStrap\Components\FeaturedImage;
use ItalyStrap\Components\BlockQuery;
use ItalyStrap\Components\Footer;
use ItalyStrap\Components\FooterWidgetArea;
use ItalyStrap\Components\Header;
use ItalyStrap\Components\Loop;
use ItalyStrap\Components\MainNavigation;
use ItalyStrap\Components\MiscNavigation;
use ItalyStrap\Components\Sidebar;
use ItalyStrap\Components\Index;
use ItalyStrap\Components\Meta;
use ItalyStrap\Components\Modified;
use ItalyStrap\Components\Pager;
use ItalyStrap\Components\Pagination;
use ItalyStrap\Components\PostAuthorInfo;
use ItalyStrap\Components\Preview;
use ItalyStrap\Components\Title;
use ItalyStrap\Config\Config;
use ItalyStrap\Config\ConfigFactory;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Config\ConfigWpSubscriber;
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
use ItalyStrap\StdLib\Media\ImageSize;
use ItalyStrap\StdLib\Media\ImageSizeInterface;
use ItalyStrap\Theme\AfterSetupThemeEvent;
use ItalyStrap\Config\ConfigCurrentTemplateSubscriber;
use ItalyStrap\Theme\License;
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

		ImageSizeInterface::class,

		AuthorInfo::class,
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

		ImageSizeInterface::class			=> ImageSize::class,
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
			 '+config'	=> static function (): ConfigInterface {
				return ConfigFactory::make( get_config_file_content( 'theme/sidebars' ) )
					->merge(get_config_file_content( 'theme/footer-widget-area' ));
			 },
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

		EditorSubscriber::class => [
			'+finder'	=> static function ( string $named_param, Injector $injector ) {
				$config = $injector->make( ConfigInterface::class );

				$stylesheet_dir = $config->get( \ItalyStrap\Config\ConfigThemeProvider::STYLESHEET_DIR );
				$template_dir = $config->get( \ItalyStrap\Config\ConfigThemeProvider::TEMPLATE_DIR );

				$finder = (new FinderFactory())->make()
					->in( [
						$stylesheet_dir . '/assets/',
						$template_dir . '/assets/',
					] );

				$finder->names([
					'../css/editor-style.css',
					'../assets/css/editor-style.css',
				]);

				return $finder;
			},
		],

		Components\Navigations\Navbar::class	=> [
			':fallback_cb' => [ Navbar\BootstrapNavMenu::class, 'fallback' ],
		],
		Components\Navigations\Pagination::class	=> [
			':config'	=> ConfigFactory::make( get_config_file_content( 'components/pagination' ) ),
		],

		PostAuthorInfo::class => [
			'+view' => static function ( string $named_param, Injector $injector ): AuthorInfo {
				return $injector->make( AuthorInfo::class );
			}
		],
		ArchiveAuthorInfo::class => [
			'+view' => static function ( string $named_param, Injector $injector ): AuthorInfo {
				return $injector->make( AuthorInfo::class );
			}
		],

		FooterWidgetArea::class => [
			':config' => ConfigFactory::make(require_once __DIR__ . '../../theme/footer-widget-area.php')
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
	AurynConfig::DELEGATIONS			=> [
		\WP_Theme::class => static function (): \WP_Theme {
			return \wp_get_theme( \get_template() );
		},
		\WP_Query::class => static function (): \WP_Query {
			global $wp_query;
			return $wp_query;
		},
	],

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

		AfterSetupThemeEvent::class,
		License::class,
		ConfigCurrentTemplateSubscriber::class,
		ConfigWpSubscriber::class,

		ExperimentalCustomizerOptionWithAndPosition::class,
		OembedWrapper::class,

		/**
		 * Register Theme stuff
		 */
		NavMenusSubscriber::class,
		SidebarsSubscriber::class,
//		SupportSubscriber::class,
		TextDomainSubscriber::class,
		ThumbnailsSubscriber::class,
		PostTypeSupportSubscriber::class,


		Custom\Metabox\Register::class,

		Admin\Nav_Menu\ItemCustomFields::class,
		Customizer\ThemeCustomizer::class,
		InlineStyleSubscriber::class,

		/**
		 * With this class I can lazyload the AssetManager::class
		 * see above in the PROXY config.
		 */
		AssetsSubscriber::class,
		Asset\EditorSubscriber::class,
	],

	/**
	 * ========================================================================
	 *
	 * Components Subscriber Classes
	 *
	 * ========================================================================
	 */
	ComponentSubscriberExtension::class => [

		Breadcrumbs::class,

		PostAuthorInfo::class,
		ArchiveAuthorInfo::class,
		ArchiveHeadline::class,

		FeaturedImage::class,
		Title::class,
		Meta::class,
		Preview::class,
		Content::class,
		Excerpt::class,
		Modified::class,
		Pager::class,
		Pagination::class,
//				BlockQuery::class,

		Sidebar::class,

		Entry::class,

		EntryNoneImage::class,
		EntryNoneTitle::class,
		EntryNoneContent::class,
		EntryNone::class,

		Loop::class,

		MiscNavigation::class,
		CustomHeaderImage::class,
		MainNavigation::class,

		Comments::class,
		Colophon::class,
		Header::class,
		FooterWidgetArea::class,
		Footer::class,
		Index::class => Index::class,
	],
];
