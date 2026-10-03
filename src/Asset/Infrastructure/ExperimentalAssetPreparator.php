<?php

declare(strict_types=1);

namespace ItalyStrap\Asset\Infrastructure;

use Auryn\Injector;
use ItalyStrap\Asset\Asset;
use ItalyStrap\Asset\AssetManager;
use ItalyStrap\Asset\ConfigBuilder;
use ItalyStrap\Asset\Debug\DebugScript;
use ItalyStrap\Asset\Debug\DebugStyle;
use ItalyStrap\Asset\Loader\GeneratorLoader;
use ItalyStrap\Asset\Script;
use ItalyStrap\Asset\Style;
use ItalyStrap\Event\GlobalDispatcher;

use function array_map;
use function array_merge;
use function array_unique;
use function array_values;
use function ItalyStrap\Config\get_config_file_content_last;

final class ExperimentalAssetPreparator
{
    public function __invoke(AssetManager $manager, Injector $injector): void
    {
        /** @var GlobalDispatcher $event_dispatcher */
        $event_dispatcher = $injector->make(GlobalDispatcher::class);

        /** @var ThemeAssetResolver $resolver */
        $resolver = $injector->make(ThemeAssetResolver::class);

        $injector->defineParam('base_url', \get_option('siteurl') . '/');
        /** @psalm-suppress UndefinedConstant */
        $injector->defineParam('base_path', ABSPATH);

        /** @var ConfigBuilder $config_builder */
        $config_builder = $injector->make(ConfigBuilder::class);

        $config_builder->withType(
            Style::EXTENSION,
            \ItalyStrap\Core\is_debug() ? DebugStyle::class : Style::class
        );
        $config_builder->withType(
            Script::EXTENSION,
            \ItalyStrap\Core\is_debug() ? DebugScript::class : Script::class
        );
        $config_builder->withVersion(new WpScriptsVersion());

        /**
         * Resolves a single config entry: if FILE_NAME is provided but Asset::URL
         * is not yet set, ThemeAssetResolver locates the file in the child/parent
         * theme and reads the optional .asset.php for version + dependencies.
         */
        $resolve = static function (array $config) use ($resolver): array {
            if (!empty($config[Asset::URL]) || empty($config[ConfigBuilder::FILE_NAME])) {
                return $config;
            }

            $resolved = $resolver->resolve($config[ConfigBuilder::FILE_NAME]);
            $config[Asset::URL] = $resolved['url'];

            if (!isset($config[Asset::VERSION])) {
                $config[Asset::VERSION] = $resolved['version'];
            }

            $config[Asset::DEPENDENCIES] = array_values(array_unique(array_merge(
                (array) ($config[Asset::DEPENDENCIES] ?? []),
                $resolved['dependencies']
            )));

            return $config;
        };

        /** @var array<int, array> $styles */
        $styles = $event_dispatcher->filter(
            'italystrap_config_enqueue_style',
            get_config_file_content_last('assets/styles')
        );

        /** @var array<int, array> $scripts */
        $scripts = $event_dispatcher->filter(
            'italystrap_config_enqueue_script',
            get_config_file_content_last('assets/scripts')
        );

        $config_builder->addConfig(array_map($resolve, $styles));
        $config_builder->addConfig(array_map($resolve, $scripts));

        $asset_loader = $injector->make(GeneratorLoader::class);
        $assets = $asset_loader->load($config_builder->parseConfig());

        $manager->withAssets(...$assets);
    }
}
