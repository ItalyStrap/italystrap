<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Integration\Assets\Application;

use ItalyStrap\Asset\EventName;
use ItalyStrap\Asset\Handle;
use ItalyStrap\Asset\Style;
use ItalyStrap\Assets\Application\ConfigAssetsSubscriber;
use ItalyStrap\Tests\IntegrationTestCase;
use PHPUnit\Framework\Assert;

use function ItalyStrap\Factory\injector;

class ConfigAssetsSubscriberTest extends IntegrationTestCase
{
    // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore -- Codeception method
    public function _before(): void
    {
        parent::_before();
        // Defined on template_include, before wp_enqueue_scripts
        \defined('CURRENT_TEMPLATE_SLUG') || \define('CURRENT_TEMPLATE_SLUG', 'index');
        $GLOBALS['wp_scripts'] = null;
        $GLOBALS['wp_styles'] = null;
    }

    // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore -- Codeception method
    public function _after(): void
    {
        \remove_all_filters(ConfigAssetsSubscriber::STYLES_EVENT);
        \remove_all_filters(ConfigAssetsSubscriber::SCRIPTS_EVENT);
        parent::_after();
    }

    public function testItLoadsOnTheFrontEnd(): void
    {
        Assert::assertSame(
            [EventName::FRONT_END => 'load'],
            \iterator_to_array($this->makeInstance()->getSubscribedEvents())
        );
    }

    public function testItLoadsTheAssetsOfTheConfigFiles(): void
    {
        $this->makeInstance()->load();

        Assert::assertTrue(\wp_style_is(\CURRENT_TEMPLATE_SLUG, 'enqueued'));
        Assert::assertTrue(\wp_script_is(\CURRENT_TEMPLATE_SLUG, 'enqueued'));
        Assert::assertSame(
            \get_template_directory_uri() . '/build/js/index.js',
            \wp_scripts()->registered[\CURRENT_TEMPLATE_SLUG]->src
        );
        Assert::assertSame(1, \wp_scripts()->get_data(\CURRENT_TEMPLATE_SLUG, 'group'));
    }

    public function testTheMainScriptHasTheParamsOfTheAjaxRequests(): void
    {
        $this->makeInstance()->load();

        $before = \implode('', \array_filter((array) \wp_scripts()->get_data(\CURRENT_TEMPLATE_SLUG, 'before')));
        Assert::assertStringContainsString('var pluginParams = ', $before);
        Assert::assertStringContainsString('admin-ajax.php', $before);
        Assert::assertStringContainsString('"ajaxnonce":"', $before);
    }

    public function testTheFiltersAddTheAssets(): void
    {
        \add_filter(ConfigAssetsSubscriber::STYLES_EVENT, static fn (array $styles): array => [
            ...$styles,
            new Style(new Handle('my-child-style'), 'https://example.com/child.css'),
        ]);

        $this->makeInstance()->load();

        Assert::assertTrue(\wp_style_is('my-child-style', 'enqueued'));
    }

    public function testTheValuesOfTheFiltersThatAreNotAssetsAreSkipped(): void
    {
        \add_filter(ConfigAssetsSubscriber::SCRIPTS_EVENT, static fn (array $scripts): array => [
            ...$scripts,
            ['handle' => 'old-array-config', 'file_name' => 'build/js/old.js'],
            'not an asset',
        ]);
        \add_filter(ConfigAssetsSubscriber::STYLES_EVENT, static fn (): string => 'not a list');

        $this->makeInstance()->load();

        Assert::assertFalse(\wp_script_is('old-array-config', 'registered'));
        Assert::assertTrue(\wp_script_is(\CURRENT_TEMPLATE_SLUG, 'enqueued'));
        Assert::assertFalse(\wp_style_is(\CURRENT_TEMPLATE_SLUG, 'registered'));
    }

    private function makeInstance(): ConfigAssetsSubscriber
    {
        return injector()->make(ConfigAssetsSubscriber::class);
    }
}
