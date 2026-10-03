<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Customizer;

use ItalyStrap\Asset\Application\CustomizerAssetsSubscriber;
use ItalyStrap\Asset\Infrastructure\ThemeAssetResolver;
use ItalyStrap\Tests\UnitTestCase;
use Prophecy\Argument;

class CustomizerAssetsSubscriberTest extends UnitTestCase
{
    private function makeResolver(array $resolved): ThemeAssetResolver
    {
        $resolver = $this->prophet->prophesize(ThemeAssetResolver::class);
        $resolver->resolve(Argument::type('string'))->willReturn($resolved);
        return $resolver->reveal();
    }

    public function testItShouldSubscribeToCustomizerHooks(): void
    {
        $sut = new CustomizerAssetsSubscriber(
            $this->makeResolver(['url' => '', 'dependencies' => [], 'version' => null])
        );

        self::assertSame(
            [
                'customize_preview_init'             => 'enqueueScriptOnLivePreview',
                'customize_controls_enqueue_scripts' => 'enqueueCustomizeControl',
            ],
            $sut->getSubscribedEvents(),
            ''
        );
    }

    public function testItShouldEnqueueLivePreviewScriptFromBuildCandidate(): void
    {
        $resolved = [
            'url'          => 'http://wordpress/wp-content/themes/italystrap/build/customizer/live-preview.js',
            'dependencies' => [],
            'version'      => null,
        ];

        $sut = new CustomizerAssetsSubscriber($this->makeResolver($resolved));

        $this->defineFunction('wp_enqueue_script', static function (
            string $handle,
            string $src,
            array $dependencies,
            $version,
            bool $in_footer
        ): void {
            self::assertSame(CustomizerAssetsSubscriber::class . '-preview', $handle, '');
            self::assertSame('http://wordpress/wp-content/themes/italystrap/build/customizer/live-preview.js', $src, '');
            self::assertSame(['customize-preview'], $dependencies, '');
            self::assertNull($version, '');
            self::assertTrue($in_footer, '');
        });

        $sut->enqueueScriptOnLivePreview();
    }

    public function testItShouldEnqueueControlsScriptFromBuildCandidate(): void
    {
        $resolved = [
            'url'          => 'http://wordpress/wp-content/themes/italystrap/build/customizer/customize-controls.js',
            'dependencies' => [],
            'version'      => null,
        ];

        $sut = new CustomizerAssetsSubscriber($this->makeResolver($resolved));

        $this->defineFunction('wp_enqueue_script', static function (
            string $handle,
            string $src,
            array $dependencies,
            $version,
            bool $in_footer
        ): void {
            self::assertSame(CustomizerAssetsSubscriber::class . '-controls', $handle, '');
            self::assertSame('http://wordpress/wp-content/themes/italystrap/build/customizer/customize-controls.js', $src, '');
            self::assertSame(['customize-controls'], $dependencies, '');
            self::assertNull($version, '');
            self::assertTrue($in_footer, '');
        });

        $sut->enqueueCustomizeControl();
    }

    public function testItShouldMergeResolvedDependenciesWithRequiredOnes(): void
    {
        $resolved = [
            'url'          => 'http://wordpress/wp-content/themes/italystrap/build/customizer/live-preview.js',
            'dependencies' => ['wp-dom-ready'],
            'version'      => 'abc123',
        ];

        $sut = new CustomizerAssetsSubscriber($this->makeResolver($resolved));

        $this->defineFunction('wp_enqueue_script', static function (
            string $handle,
            string $src,
            array $dependencies,
            $version,
            bool $in_footer
        ): void {
            self::assertSame(['customize-preview', 'wp-dom-ready'], $dependencies, '');
            self::assertSame('abc123', $version, '');
        });

        $sut->enqueueScriptOnLivePreview();
    }
}
