<?php

declare(strict_types=1);

use Auryn\Injector;
use ItalyStrap\Cache\ConfigCacheFile;
use ItalyStrap\Asset\Module as AssetModule;
use ItalyStrap\Config\ConfigFactory;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Config\ConfigProviderExtension;
use ItalyStrap\Config\ConfigThemeModsProvider;
use ItalyStrap\Customizer\Module as CustomizerModule;
use ItalyStrap\Empress\PhpFileProvider;
use ItalyStrap\Empress\ProvidersCache;
use ItalyStrap\Empress\ProvidersCollection;
use ItalyStrap\Event\Module as EventModule;
use ItalyStrap\Experimental\ExperimentalThemeFileFinderFactory;
use ItalyStrap\Experimental\Module as ExperimentalModule;
use ItalyStrap\Navigation\Module as NavigationModule;
use ItalyStrap\Theme\Module as ThemeModule;
use ItalyStrap\UI\Module as UIModule;

return static function (Injector $injector): ConfigInterface {
    $config =  (new ConfigFactory())->make();

    /**
     * One cache file per active theme, and per site on multisite,
     * so sites and child themes never share a cached config.
     */
    // A child theme in a nested folder has a stylesheet like "overclokk/overclokk-theme".
    $stylesheet = str_replace(['/', '\\'], '-', get_stylesheet());
    $cacheKey = is_multisite()
        ? get_current_blog_id() . '-' . $stylesheet
        : $stylesheet;

    /**
     * The parent and child versions are part of the file name, so a release never reads
     * the config cached by the previous one. With WP_DEBUG on, the config is always rebuilt.
     */
    $cacheFile = new ConfigCacheFile(
        get_template_directory() . '/config/cache',
        $cacheKey,
        wp_get_theme(get_template())->get('Version') . '|' . wp_get_theme()->get('Version')
    );

    $cacheEnabled = !(\defined('WP_DEBUG') && WP_DEBUG);
    if ($cacheEnabled) {
        $cacheFile->removeStale();
    }

    $cache = new ProvidersCache(
        file: $cacheFile->path(),
        fileMode: 0666,
        enabled: $cacheEnabled,
    );

    $collection = new ProvidersCollection(
        $injector,
        $config,
        $cache,
        [
            // First we load Modules from packages
            EventModule::class,

            // Then we load Modules from this theme
            ThemeModule::class,
            AssetModule::class,
            CustomizerModule::class,
            ExperimentalModule::class,
            NavigationModule::class,
            UIModule::class,
            new PhpFileProvider(
                '/config/autoload/{{,*.}global,{,*.}local}.php',
                $injector->execute(ExperimentalThemeFileFinderFactory::class)
            ),
            /** This must run after all */
            fn(): array => [
                ConfigProviderExtension::class => [
                    /** This must run after all */
                    ConfigThemeModsProvider::class,
                ],
            ],
        ],
    );

    $collection->aggregate();

    return $config;
};
