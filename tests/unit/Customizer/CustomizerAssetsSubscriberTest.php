<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Customizer;

use Codeception\Test\Unit;
use ItalyStrap\Asset\AssetLoader;
use ItalyStrap\Asset\ScriptLoader;
use ItalyStrap\Assets\Application\CustomizerAssetsSubscriber;
use ItalyStrap\Assets\Infrastructure\ThemeFolders;
use ItalyStrap\Tests\Asset\ScriptRegistrySpy;

class CustomizerAssetsSubscriberTest extends Unit
{
    private const PARENT_URL = 'http://wordpress/wp-content/themes/italystrap';

    private ScriptRegistrySpy $scripts;

    // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore -- Codeception method
    protected function _before(): void
    {
        $this->scripts = new ScriptRegistrySpy();
    }

    public function testItShouldSubscribeToCustomizerHooks(): void
    {
        self::assertSame(
            [
                'customize_preview_init'             => 'enqueueScriptOnLivePreview',
                'customize_controls_enqueue_scripts' => 'enqueueCustomizeControl',
            ],
            $this->makeInstance()->getSubscribedEvents()
        );
    }

    public function testItShouldEnqueueLivePreviewScriptInTheFooter(): void
    {
        $this->makeInstance()->enqueueScriptOnLivePreview();

        self::assertSame([
            [
                'register',
                CustomizerAssetsSubscriber::PREVIEW_HANDLE,
                self::PARENT_URL . '/build/customizer/live-preview.js',
                ['customize-preview'],
                null,
                ['in_footer' => true],
            ],
            ['enqueue', CustomizerAssetsSubscriber::PREVIEW_HANDLE],
        ], $this->scripts->calls);
    }

    public function testItShouldEnqueueControlsScriptInTheFooter(): void
    {
        $this->makeInstance()->enqueueCustomizeControl();

        self::assertSame([
            [
                'register',
                CustomizerAssetsSubscriber::CONTROLS_HANDLE,
                self::PARENT_URL . '/build/customizer/customize-controls.js',
                ['customize-controls'],
                null,
                ['in_footer' => true],
            ],
            ['enqueue', CustomizerAssetsSubscriber::CONTROLS_HANDLE],
        ], $this->scripts->calls);
    }

    private function makeInstance(): CustomizerAssetsSubscriber
    {
        return new CustomizerAssetsSubscriber(
            new ThemeFolders([
                '/missing/child' => 'http://wordpress/wp-content/themes/child',
                '/missing/parent' => self::PARENT_URL,
            ]),
            new AssetLoader(new ScriptLoader($this->scripts)),
        );
    }
}
