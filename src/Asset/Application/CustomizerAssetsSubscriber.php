<?php

declare(strict_types=1);

namespace ItalyStrap\Asset\Application;

use ItalyStrap\Asset\Asset;
use ItalyStrap\Asset\Infrastructure\ThemeAssetResolver;
use ItalyStrap\Asset\Script;
use ItalyStrap\Config\ConfigFactory;
use ItalyStrap\Event\SubscriberInterface;

use function array_merge;
use function array_unique;
use function array_values;

class CustomizerAssetsSubscriber implements SubscriberInterface
{
    private ThemeAssetResolver $resolver;

    public function __construct(ThemeAssetResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    public function getSubscribedEvents(): iterable
    {
        return [
            'customize_preview_init'             => 'enqueueScriptOnLivePreview',
            'customize_controls_enqueue_scripts' => 'enqueueCustomizeControl',
        ];
    }

    /**
     * Enqueues the live-preview script used by the Customizer preview iframe.
     */
    public function enqueueScriptOnLivePreview(): void
    {
        $this->enqueueScript(
            self::class . '-preview',
            'build/customizer/live-preview.js',
            ['customize-preview']
        );
    }

    /**
     * Enqueues the controls script used inside the Customizer panel.
     */
    public function enqueueCustomizeControl(): void
    {
        $this->enqueueScript(
            self::class . '-controls',
            'build/customizer/customize-controls.js',
            ['customize-controls']
        );
    }

    private function enqueueScript(string $handle, string $relative_path, array $required_deps): void
    {
        $resolved = $this->resolver->resolve($relative_path);

        $config = (new ConfigFactory())->make([
            Asset::HANDLE      => $handle,
            Asset::URL         => $resolved['url'],
            Asset::DEPENDENCIES => array_values(array_unique(array_merge($required_deps, $resolved['dependencies']))),
            Asset::VERSION     => $resolved['version'],
            Asset::IN_FOOTER   => true,
        ]);

        (new Script($config))->enqueue();
    }
}
