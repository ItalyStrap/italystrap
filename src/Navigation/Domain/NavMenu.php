<?php

declare(strict_types=1);

namespace ItalyStrap\Navigation\Domain;

use Walker_Nav_Menu;
use function wp_nav_menu;

class NavMenu implements NavMenuInterface
{
    public const MENU = 'menu';
    public const CONTAINER = 'container';
    public const CONTAINER_CLASS_NAME = 'container_class';
    public const CONTAINER_ID = 'container_id';
    public const MENU_CLASS_NAME = 'menu_class';
    public const MENU_ID = 'menu_id';
    public const ECHO = 'echo';
    public const FALLBACK_CB = 'fallback_cb';
    public const BEFORE = 'before';
    public const AFTER = 'after';
    public const LINK_BEFORE = 'link_before';
    public const LINK_AFTER = 'link_after';
    public const ITEMS_WRAP = 'items_wrap';
    public const ITEMS_SPACING = 'item_spacing';
    public const DEPTH = 'depth';
    public const WALKER = 'walker';
    public const THEME_LOCATION = 'theme_location';
    public const SEARCH = 'search';

    private Walker_Nav_Menu $walker;
    private $fallback_cb;

    public function __construct(
        Walker_Nav_Menu $walker,
        callable $fallback_cb = null
    ) {
        $this->walker = $walker;
        $this->fallback_cb = $fallback_cb ?? 'wp_page_menu';
    }

    public function render(array $options = []): string
    {
        return (string)wp_nav_menu(\array_replace($this->getDefaultOptions(), $options));
    }

    private function getDefaultOptions(): array
    {
        return [
            self::MENU => '',
            self::CONTAINER => '',
            self::CONTAINER_CLASS_NAME => '',
            self::CONTAINER_ID => '',
            self::MENU_CLASS_NAME => '',
            self::MENU_ID => '',
            self::ECHO => false,
            self::FALLBACK_CB => $this->fallback_cb,
            self::BEFORE => '',
            self::AFTER => '',
            self::LINK_BEFORE => '<span class="item-title">',
            self::LINK_AFTER => '</span>',
            self::ITEMS_WRAP => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            self::ITEMS_SPACING => 'preserve',
            self::DEPTH => 10,
            self::WALKER => $this->walker,
            self::THEME_LOCATION => '',
            self::SEARCH => false,
        ];
    }
}
