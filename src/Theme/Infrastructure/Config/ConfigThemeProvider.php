<?php

declare(strict_types=1);

namespace ItalyStrap\Theme\Infrastructure\Config;

use ItalyStrap\Event\GlobalDispatcherInterface as EventDispatcherInterface;

class ConfigThemeProvider
{
    public const THEME_NAME = 'theme_name';
    public const THEME_VERSION = 'theme_version';
    public const THEME_AUTHOR = 'theme_author';
    public const TEMPLATE_DIR_URI = 'template_directory_uri';
    public const STYLESHEET_DIR_URI = 'stylesheet_directory_uri';
    public const TEMPLATE_DIR = 'template_directory';
    public const STYLESHEET_DIR = 'stylesheet_directory';

    public const STYLESHEET  = 'stylesheet';

    public const THEME_BETA = 'theme_beta';
    public const VIEW_DIR = 'templates';
    public const PREFIX = 'prefix';

    private \WP_Theme $theme;
    private EventDispatcherInterface $dispatcher;

    public function __construct(\WP_Theme $theme, EventDispatcherInterface $dispatcher)
    {
        $this->theme = $theme;
        $this->dispatcher = $dispatcher;
    }

    public function __invoke(): iterable
    {
        yield self::THEME_NAME => (string)$this->theme->display('Name');
        yield self::THEME_VERSION => (string)$this->theme->display('Version');
        yield self::THEME_AUTHOR => (string)$this->theme->display('Author');
        yield self::TEMPLATE_DIR_URI    => $this->theme->get_template_directory_uri();
        yield self::STYLESHEET_DIR_URI  => $this->theme->get_stylesheet_directory_uri();
        yield self::TEMPLATE_DIR    => $this->theme->get_template_directory();
        yield self::STYLESHEET_DIR => $this->theme->get_stylesheet_directory();
        yield self::STYLESHEET  => \get_stylesheet();
        yield self::THEME_BETA => false;
        yield self::VIEW_DIR => (string) $this->dispatcher->filter('italystrap_template_dir', 'templates');
        yield self::PREFIX => \strtolower((string)$this->theme->display('Name'));
    }
}
