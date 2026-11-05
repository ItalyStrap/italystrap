<?php

declare(strict_types=1);

namespace ItalyStrap\Assets;

use Auryn\Injector;
use ItalyStrap\Asset\AssetLoader;
use ItalyStrap\Asset\Core\CoreScriptRegistry;
use ItalyStrap\Asset\Core\CoreStyleRegistry;
use ItalyStrap\Asset\ScriptRegistry;
use ItalyStrap\Asset\StyleRegistry;
use ItalyStrap\Assets\Application\ConfigAssetsSubscriber;
use ItalyStrap\Assets\Application\CustomizerAssetsSubscriber;
use ItalyStrap\Assets\Application\EditorSubscriber;
use ItalyStrap\Assets\Application\InlineStyleSubscriber;
use ItalyStrap\Assets\Infrastructure\ThemeFolders;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Empress\AurynConfig;
use ItalyStrap\Event\SubscribersConfigExtension;
use ItalyStrap\Finder\FinderFactory;
use ItalyStrap\Finder\FinderInterface;
use ItalyStrap\Theme\Infrastructure\Config\ConfigThemeProvider;

class Module
{
    public function __invoke(): iterable
    {
        return [
            AurynConfig::SHARING => [
                AssetLoader::class,
                ThemeFolders::class,
            ],
            AurynConfig::ALIASES => [
                ScriptRegistry::class => CoreScriptRegistry::class,
                StyleRegistry::class => CoreStyleRegistry::class,
            ],
            AurynConfig::DEFINITIONS => [
                ThemeFolders::class => [
                    '+folders' => static function (string $named_param, Injector $injector): array {
                        $config = $injector->make(ConfigInterface::class);

                        // The child theme first, the same folders without a child theme
                        return [
                            (string) $config->get(ConfigThemeProvider::STYLESHEET_DIR)
                                => (string) $config->get(ConfigThemeProvider::STYLESHEET_DIR_URI),
                            (string) $config->get(ConfigThemeProvider::TEMPLATE_DIR)
                                => (string) $config->get(ConfigThemeProvider::TEMPLATE_DIR_URI),
                        ];
                    },
                ],
                EditorSubscriber::class => [
                    '+finder' => static function (string $named_param, Injector $injector): FinderInterface {

                        $config = $injector->make(ConfigInterface::class);
                        $stylesheet_dir = (string)$config->get(ConfigThemeProvider::STYLESHEET_DIR);
                        $template_dir = (string)$config->get(ConfigThemeProvider::TEMPLATE_DIR);
                        $finder = (new FinderFactory())->make()
                            ->in([
                                $stylesheet_dir . '/build/css',
                                $template_dir . '/build/css',
                            ]);
                        $finder->names(['editor-style.css']);
                        return $finder;
                    },
                ],
            ],
            SubscribersConfigExtension::SUBSCRIBERS => [
                InlineStyleSubscriber::class,
                ConfigAssetsSubscriber::class,
                EditorSubscriber::class,
                CustomizerAssetsSubscriber::class,
            ]
        ];
    }
}
