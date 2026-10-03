<?php

declare(strict_types=1);

namespace ItalyStrap\Theme\Application;

use ItalyStrap\Config\ConfigInterface as Config;
use ItalyStrap\Event\SubscriberInterface;

use function array_filter;
use function array_merge;
use function register_sidebar;

final class SidebarsSubscriber implements SubscriberInterface
{
    public const NAME = 'name';
    public const ID = 'id';
    public const DESCRIPTION = 'description';
    public const CLASS_NAME = 'class';
    public const BEFORE_WIDGET = 'before_widget';
    public const AFTER_WIDGET = 'after_widget';
    public const BEFORE_TITLE = 'before_title';
    public const AFTER_TITLE = 'after_title';

    public function getSubscribedEvents(): iterable
    {
        yield 'widgets_init'            => 'register';
        yield 'dynamic_sidebar_before'  => 'parseDynamicSidebarBefore';
    }

    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function register(): void
    {
        foreach ((array)$this->config->get(self::class, []) as $key => $sidebar) {
            register_sidebar($sidebar);
        }
    }

    /**
     * @param int|string $index
     */
    public function parseDynamicSidebarBefore($index): void
    {
        /** @var array<int|string, array> $wp_registered_sidebars */
        global $wp_registered_sidebars;

        if (!\array_key_exists($index, $wp_registered_sidebars)) {
            return;
        }

        $wp_registered_sidebars[$index] = array_merge(
            (array)$wp_registered_sidebars[$index],
            array_filter($this->getDefault($index))
        );
    }

    /**
     * @param int|string $id
     */
    private function getDefault($id): array
    {
        $widget_context = $id . '-widget';
        $title_context = $id . '-title';

        return [
            self::NAME => '',
            self::ID => '',
            self::DESCRIPTION => '',
            self::CLASS_NAME => '',
            self::BEFORE_WIDGET => <<<'GROUP'
<!-- wp:group {"className":"widget %2$s","layout":{"type":"constrained"}} -->
<div id="%1$s" class="wp-block-group widget %2$s">
GROUP
,
            self::AFTER_WIDGET => <<<'GROUP'
</div>
<!-- /wp:group -->
GROUP,
            self::BEFORE_TITLE => <<<'HEADING'
<!-- wp:heading {"className":"widget-title"} -->
<h2 class="wp-block-heading widget-title">
HEADING,

            self::AFTER_TITLE => <<<'HEADING'
</h2>
<!-- /wp:heading -->
HEADING,
        ];
    }
}
