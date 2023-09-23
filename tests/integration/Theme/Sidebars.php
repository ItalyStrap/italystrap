<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Integration\Theme;

use ArrayIterator;
use ItalyStrap\HTML\Attributes;
use ItalyStrap\HTML\Tag;
use ItalyStrap\Tests\IntegrationTestCase;
use ItalyStrap\Theme\SidebarsSubscriber;
use PHPUnit\Framework\Assert;

use function is_registered_sidebar;

// phpcs:disable
require_once 'BaseTheme.php';
// phpcs:enable

class Sidebars extends IntegrationTestCase
{
    protected function getInstance(): SidebarsSubscriber
    {
        return new SidebarsSubscriber($this->getConfig(), new Tag(new Attributes()));
    }

    /**
     * @test
     */
    public function itShouldRegister()
    {
        $sidebar_id = 'custom-sidebar-for-test';

        $this->config->getIterator()->willReturn(new ArrayIterator(
            [
                [
                    'name'              => __('Sidebar', 'italystrap'),
                    'id'                => $sidebar_id,
                    'before_widget'     => '<div id="%1$s" class="widget %2$s col-sm-6 col-md-12">',
                    'after_widget'      => '</div>',
                ]
            ]
        ))->shouldBeCalled(1);

        $sut = $this->getInstance();
        $sut->register();

        Assert::assertTrue(is_registered_sidebar($sidebar_id), '');
    }

    /**
     * @test
     */
    public function itParseDynamicSidebarBefore()
    {
        $sidebar_id = 'custom-sidebar-for-test';

        $this->config->getIterator()->willReturn(new ArrayIterator(
            [
                [
                    'name'              => __('Sidebar', 'italystrap'),
                    'id'                => $sidebar_id,
                    'before_widget'     => '<div id="%1$s" class="widget %2$s col-sm-6 col-md-12">',
                    'after_widget'      => '</div>',
                ]
            ]
        ))->shouldBeCalled(1);

        $sut = $this->getInstance();
        $sut->register();

        global $wp_registered_sidebars;

        $sut->parseDynamicSidebarBefore($sidebar_id);

        $sidebar = $wp_registered_sidebars[ $sidebar_id ];

        Assert::assertSame('Sidebar', $sidebar['name'], '');
        Assert::assertSame($sidebar_id, $sidebar['id'], '');
        Assert::assertEmpty($sidebar['description'], '');
        Assert::assertEmpty($sidebar['class'], '');
        Assert::assertStringContainsString('<div id="%1$s" class="widget %2$s">', $sidebar['before_widget'], '');
        Assert::assertStringContainsString('</div>', $sidebar['after_widget'], '');
        Assert::assertStringContainsString('<h3 class="widgettitle widget-title">', $sidebar['before_title'], '');
        Assert::assertStringContainsString('</h3>', $sidebar['after_title'], '');
    }
}
