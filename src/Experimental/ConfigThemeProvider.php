<?php
declare(strict_types=1);

namespace ItalyStrap\Experimental;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\EventDispatcherInterface;

class ConfigThemeProvider {

	const THEME_NAME = 'theme_name';
	const THEME_VERSION = 'theme_version';
	const THEME_AUTHOR = 'theme_author';
	const TEMPLATE_DIRECTORY_URI = 'template_directory_uri';
	const STYLESHEET_DIRECTORY_URI = 'stylesheet_directory_uri';
	const TEMPLATE_DIRECTORY = 'template_directory';
	const STYLESHEET_DIRECTORY = 'stylesheet_directory';
	const THEME_BETA = 'theme_beta';
	const VIEW_DIRECTORY = 'templates';

	private \WP_Theme $theme;
	private EventDispatcherInterface $dispatcher;

	public function __construct( \WP_Theme $theme, EventDispatcherInterface $dispatcher ) {
		$this->theme = $theme;
		$this->dispatcher = $dispatcher;
	}

	public function __invoke(): iterable {
		yield self::THEME_NAME => $this->theme->display( 'Name' );
		yield self::THEME_VERSION => $this->theme->display( 'Version' );
		yield self::THEME_AUTHOR => $this->theme->display( 'Author', false );
		yield self::TEMPLATE_DIRECTORY_URI	=> $this->theme->get_template_directory_uri();
		yield self::STYLESHEET_DIRECTORY_URI	=> $this->theme->get_stylesheet_directory_uri();
		yield self::TEMPLATE_DIRECTORY	=> $this->theme->get_template_directory();
		yield self::STYLESHEET_DIRECTORY => $this->theme->get_stylesheet_directory();
		yield self::THEME_BETA => false;
		yield self::VIEW_DIRECTORY => (string) $this->dispatcher->filter( 'italystrap_template_dir', 'templates' );
	}
}
