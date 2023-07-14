<?php

declare(strict_types=1);

namespace ItalyStrap;

use Auryn\Injector;
use ItalyStrap\Asset\AssetManager;
use ItalyStrap\Asset\ExperimentalAssetPreparator;
use ItalyStrap\Asset\EditorSubscriber;
use ItalyStrap\Asset\InlineStyleSubscriber;
use ItalyStrap\Config\Config;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Config\ConfigWpSubscriber;
use ItalyStrap\Customizer\CustomizerAssetsSubscriber;
use ItalyStrap\Customizer\CustomizerBodyTagAttributesSubscriber;
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
use ItalyStrap\Navigation\NavMenu;
use ItalyStrap\Navigation\NavMenuInterface;
use ItalyStrap\Navigation\NavMenuLocation;
use ItalyStrap\Navigation\NavMenuLocationInterface;
use ItalyStrap\StdLib\Media\ImageSize;
use ItalyStrap\StdLib\Media\ImageSizeInterface;
use ItalyStrap\Theme\AfterSetupThemeEvent;
use ItalyStrap\Config\ConfigCurrentTemplateSubscriber;
use ItalyStrap\Theme\License;
use ItalyStrap\Theme\Metaboxes;
use ItalyStrap\Theme\NavMenusSubscriber;
use ItalyStrap\Theme\SidebarsSubscriber;
use ItalyStrap\Theme\SupportSubscriber;
use ItalyStrap\Theme\TextDomainSubscriber;
use ItalyStrap\Theme\ThumbnailsSubscriber;
use ItalyStrap\Theme\PostTypeSupportSubscriber;
use ItalyStrap\HTML\TagInterface;
use ItalyStrap\View\ViewInterface;
use Walker_Nav_Menu;

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
    AurynConfig::SHARING                => [
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

        \WP_Theme::class,
        \WP_Query::class,
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
    AurynConfig::ALIASES                => [
        EventDispatcherInterface::class     => EventDispatcher::class,
        SubscriberRegisterInterface::class  => SubscriberRegister::class,

        ConfigInterface::class              => Config::class,

        AttributesInterface::class          => Attributes::class,
        TagInterface::class                 => Tag::class,

        FileInfoFactoryInterface::class     => FileInfoFactory::class,
        SearchFileStrategy::class           => FilesHierarchyIterator::class,
        FinderInterface::class              => Finder::class,

        ViewInterface::class                => View\View::class,

        ImageSizeInterface::class           => ImageSize::class,

        NavMenuLocationInterface::class     => NavMenuLocation::class,
        NavMenuInterface::class             => NavMenu::class,

        Walker_Nav_Menu::class              => Navbar\BootstrapNavMenu::class,
    ],

    /**
     * ==========================================================
     *
     * Autoload Classes definitions
     *
     * @example :
     * 'walker'     => '\NameSpace\ClassName',
     * ':walker'    => new \NameSpace\ClassName(),
     * '+walker'    => function () {
     *      return new \NameSpace\ClassName();
     * },
     *
     * ==========================================================
     */
    AurynConfig::DEFINITIONS            => [
        View\View::class => [
            '+finder' => static function (string $named_param, Injector $injector): FinderInterface {

                $config = $injector->make(ConfigInterface::class);
                $stylesheet_dir = $config->get(\ItalyStrap\Config\ConfigThemeProvider::STYLESHEET_DIR);
                $template_dir = $config->get(\ItalyStrap\Config\ConfigThemeProvider::TEMPLATE_DIR);
                $view_dir = $config->get(\ItalyStrap\Config\ConfigThemeProvider::VIEW_DIR);
                $finder = (new FinderFactory())->make()
                    ->in([
                        $stylesheet_dir . '/' . $view_dir,
                        $template_dir . '/' . $view_dir,
                    ]);
                return $finder;
            },
        ],

        EditorSubscriber::class => [
            '+finder'   => static function (string $named_param, Injector $injector) {

                $config = $injector->make(ConfigInterface::class);
                $stylesheet_dir = $config->get(\ItalyStrap\Config\ConfigThemeProvider::STYLESHEET_DIR);
                $template_dir = $config->get(\ItalyStrap\Config\ConfigThemeProvider::TEMPLATE_DIR);
                $finder = (new FinderFactory())->make()
                    ->in([
                        $stylesheet_dir . '/assets/',
                        $template_dir . '/assets/',
                    ]);
                $finder->names([
                    '../css/editor-style.css',
                    '../assets/css/editor-style.css',
                ]);
                return $finder;
            },
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
    AurynConfig::DEFINE_PARAM           => [
    ],

    /**
     * ========================================================================
     *
     * Autoload Delegates
     * @link https://github.com/rdlowrey/auryn#instantiation-delegates
     * 'MyComplexClass' => $complexClassFactory,
     * 'SomeClassWithDelegatedInstantiation'    => 'MyFactory',
     * 'SomeClassWithDelegatedInstantiation'    => 'MyFactory::factoryMethod'
     *
     * string
     *
     * ========================================================================
     */
    AurynConfig::DELEGATIONS            => [
        \WP_Theme::class => static function (): \WP_Theme {

            return \wp_get_theme(\get_template());
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
    AurynConfig::PREPARATIONS           => [

        /**
         * This class is lazy loaded
         */
        AssetManager::class         => new ExperimentalAssetPreparator(),
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
    AurynConfig::PROXY                  => [
        AssetManager::class,
//      SidebarsSubscriber::class,
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
    SubscribersConfigExtension::SUBSCRIBERS             => [

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
        SupportSubscriber::class,
        TextDomainSubscriber::class,
        ThumbnailsSubscriber::class,
        PostTypeSupportSubscriber::class,
        Metaboxes::class,

        Admin\Nav_Menu\ItemCustomFields::class,

        CustomizerBodyTagAttributesSubscriber::class,
        CustomizerAssetsSubscriber::class,
        InlineStyleSubscriber::class,

        /**
         * With this class I can lazyload the AssetManager::class
         * see above in the PROXY config.
         */
        AssetsSubscriber::class,
        Asset\EditorSubscriber::class,
    ],
];
