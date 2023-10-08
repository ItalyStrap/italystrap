<?php

declare(strict_types=1);

namespace ItalyStrap\Asset;

use Auryn\Injector;
use ItalyStrap\Asset\Application\EditorSubscriber;
use ItalyStrap\Asset\Application\InlineStyleSubscriber;
use ItalyStrap\Asset\Infrastructure\ExperimentalAssetPreparator;
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

            ],
            AurynConfig::ALIASES => [

            ],
            AurynConfig::DEFINITIONS => [
                EditorSubscriber::class => [
                    '+finder' => static function (string $named_param, Injector $injector): FinderInterface {

                        $config = $injector->make(ConfigInterface::class);
                        $stylesheet_dir = (string)$config->get(ConfigThemeProvider::STYLESHEET_DIR);
                        $template_dir = (string)$config->get(ConfigThemeProvider::TEMPLATE_DIR);
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
            AurynConfig::PREPARATIONS => [

                /**
                 * This class is lazy loaded
                 */
                AssetManager::class => new ExperimentalAssetPreparator(),
            ],
            AurynConfig::PROXY => [
                AssetManager::class,
            ],
            SubscribersConfigExtension::SUBSCRIBERS => [
                InlineStyleSubscriber::class,
                AssetsSubscriber::class,
                EditorSubscriber::class,
            ]
        ];
    }
}
