<?php

declare(strict_types=1);

namespace ItalyStrap\Asset;

use Auryn\Injector;
use ItalyStrap\Asset\Debug\DebugScript;
use ItalyStrap\Asset\Debug\DebugStyle;
use ItalyStrap\Asset\Loader\GeneratorLoader;
use ItalyStrap\Event\EventDispatcher;
use ItalyStrap\Finder\FinderFactory;

use function ItalyStrap\Config\get_config_file_content_last;

final class ExperimentalAssetPreparator
{
    public function __invoke(AssetManager $manager, Injector $injector)
    {

        /** @var EventDispatcher $event_dispatcher */
        $event_dispatcher = $injector->make(EventDispatcher::class);
        $experimental_assets_path_generator = static function (string $dir): array {
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
            ->in($experimental_assets_path_generator('css/'));

        $js_finder = ( new FinderFactory() )->make()
            ->in($experimental_assets_path_generator('js/'));

        $injector->defineParam('base_url', \get_option('siteurl') . '/');
        /**
         * @psalm-suppress UndefinedConstant
         */
        $injector->defineParam('base_path', ABSPATH);

        /** @var ConfigBuilder $config_builder */
        $config_builder = $injector->make(ConfigBuilder::class);

        $config_builder->withType(
            Style::EXTENSION,
            \ItalyStrap\Core\is_debug() ? DebugStyle::class : Style::class
        );
        $config_builder->withFinderForType(Style::EXTENSION, $css_finder);

        $config_builder->withType(
            Script::EXTENSION,
            \ItalyStrap\Core\is_debug() ? DebugScript::class : Script::class
        );
        $config_builder->withFinderForType(Script::EXTENSION, $js_finder);

        /**
         * @todo Maybe I can add a check for forcing child to load its own assets
         *       is_child() ? [] : get_config_file_content_last( 'assets/[styles|scripts]' )
         *       because assetss should not be loaded from parent by default.
         * @var array<int, mixed>
         */
        $styles = $event_dispatcher->filter(
            'italystrap_config_enqueue_style',
            get_config_file_content_last('assets/styles')
        );

        /** @var array<int, mixed> $scripts */
        $scripts = $event_dispatcher->filter(
            'italystrap_config_enqueue_script',
            get_config_file_content_last('assets/scripts')
        );

        $config_builder->addConfig($styles);
        $config_builder->addConfig($scripts);

        $asset_loader = $injector->make(GeneratorLoader::class);
        $assets = $asset_loader->load($config_builder->parseConfig());

        $manager->withAssets(...$assets);
    }
}
