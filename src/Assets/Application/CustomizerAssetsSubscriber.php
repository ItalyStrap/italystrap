<?php

declare(strict_types=1);

namespace ItalyStrap\Assets\Application;

use ItalyStrap\Asset\AssetLoader;
use ItalyStrap\Asset\Dependencies;
use ItalyStrap\Asset\Handle;
use ItalyStrap\Asset\Script;
use ItalyStrap\Asset\ScriptLoading;
use ItalyStrap\Assets\Infrastructure\ThemeFolders;
use ItalyStrap\Event\SubscriberInterface;

/**
 * The scripts of the Customizer preview and of its controls.
 */
final readonly class CustomizerAssetsSubscriber implements SubscriberInterface
{
    public const PREVIEW_HANDLE = 'italystrap-customize-preview';
    public const CONTROLS_HANDLE = 'italystrap-customize-controls';

    public function __construct(
        private ThemeFolders $folders,
        private AssetLoader $assets,
    ) {
    }

    public function getSubscribedEvents(): iterable
    {
        return [
            'customize_preview_init'             => 'enqueueScriptOnLivePreview',
            'customize_controls_enqueue_scripts' => 'enqueueCustomizeControl',
        ];
    }

    /**
     * The live preview script of the Customizer preview iframe.
     */
    public function enqueueScriptOnLivePreview(): void
    {
        $this->load(self::PREVIEW_HANDLE, 'build/customizer/live-preview.js', 'customize-preview');
    }

    /**
     * The script of the controls inside the Customizer panel.
     */
    public function enqueueCustomizeControl(): void
    {
        $this->load(self::CONTROLS_HANDLE, 'build/customizer/customize-controls.js', 'customize-controls');
    }

    private function load(string $handle, string $path, string $dependency): void
    {
        $file = $this->folders->file($path);

        $this->assets->load(new Script(
            handle: new Handle($handle),
            source: $file->url(),
            dependencies: (new Dependencies($dependency))->with($file->dependencies()),
            version: $file->version(),
            loading: new ScriptLoading(inFooter: true),
        ));
    }
}
