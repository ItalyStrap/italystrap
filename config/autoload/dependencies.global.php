<?php

declare(strict_types=1);

namespace ItalyStrap;

use Auryn\Injector;
use ItalyStrap\Config\Config;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Customizer\CustomizerAssetsSubscriber;
use ItalyStrap\Customizer\CustomizerBodyTagAttributesSubscriber;
use ItalyStrap\Empress\AurynConfig;
use ItalyStrap\Event\SubscribersConfigExtension;
use ItalyStrap\Experimental\ExperimentalCustomizerOptionWithAndPosition;
use ItalyStrap\Experimental\OembedWrapperSubscriber;
use ItalyStrap\Finder\FileInfoFactory;
use ItalyStrap\Finder\FileInfoFactoryInterface;
use ItalyStrap\Finder\FilesHierarchyIterator;
use ItalyStrap\Finder\FinderFactory;
use ItalyStrap\Finder\FinderInterface;
use ItalyStrap\Finder\SearchFileStrategy;
use ItalyStrap\HTML\Attributes;
use ItalyStrap\HTML\AttributesInterface;
use ItalyStrap\HTML\Tag;
use ItalyStrap\HTML\TagInterface;
use ItalyStrap\View\ViewInterface;

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
        /**
         * Make sure the config is shared.
         * Already shared in bootstrap.php or in ACM if it is active.
         */
        Config::class,

        Attributes::class,
        Tag::class,
        View\View::class,

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

        ConfigInterface::class              => Config::class,

        AttributesInterface::class          => Attributes::class,
        TagInterface::class                 => Tag::class,

        FileInfoFactoryInterface::class     => FileInfoFactory::class,
        SearchFileStrategy::class           => FilesHierarchyIterator::class,
//        FinderInterface::class              => Finder::class,

        ViewInterface::class                => View\View::class,
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
                $stylesheet_dir = $config->get(Theme\Infrastructure\Config\ConfigThemeProvider::STYLESHEET_DIR);
                $template_dir = $config->get(Theme\Infrastructure\Config\ConfigThemeProvider::TEMPLATE_DIR);
                $view_dir = $config->get(Theme\Infrastructure\Config\ConfigThemeProvider::VIEW_DIR);
                $finder = (new FinderFactory())->make()
                    ->in([
                        $stylesheet_dir . '/' . $view_dir,
                        $template_dir . '/' . $view_dir,
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

        ExperimentalCustomizerOptionWithAndPosition::class,
        OembedWrapperSubscriber::class,

        CustomizerBodyTagAttributesSubscriber::class,
        CustomizerAssetsSubscriber::class,
    ],
];
