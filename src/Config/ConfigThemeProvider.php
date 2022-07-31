<?php
declare(strict_types=1);

namespace ItalyStrap\Config;

use ItalyStrap\Event\EventDispatcherInterface;

class ConfigThemeProvider {

	const THEME_NAME = 'theme_name';
	const THEME_VERSION = 'theme_version';
	const THEME_AUTHOR = 'theme_author';
	const TEMPLATE_DIR_URI = 'template_directory_uri';
	const STYLESHEET_DIR_URI = 'stylesheet_directory_uri';
	const TEMPLATE_DIR = 'template_directory';
	const STYLESHEET_DIR = 'stylesheet_directory';
	const THEME_BETA = 'theme_beta';
	const VIEW_DIR = 'templates';

	private \WP_Theme $theme;
	private EventDispatcherInterface $dispatcher;

	public function __construct( \WP_Theme $theme, EventDispatcherInterface $dispatcher ) {
		$this->theme = $theme;
		$this->dispatcher = $dispatcher;
	}

	public function __invoke(): iterable {
//		'ITALYSTRAP_THEME'				=> true,
//		'ITALYSTRAP_THEME_NAME'			=> wp_get_theme( $get_template )->display( 'Name' ),
//		'ITALYSTRAP_THEME_VERSION'		=> wp_get_theme( $get_template )->display( 'Version' ),
//		'ITALYSTRAP_THEME_AUTHOR'		=> wp_get_theme( $get_template )->display( 'Author', false ),
//		'ITALYSTRAP_CURRENT_THEME_NAME'	=> $current_theme_name,
//		'PREFIX'						=> $prefix,
//		'_PREFIX'						=> '_' . $prefix,
//		'TEMPLATEURL'					=> get_template_directory_uri(),
//		'STYLESHEETURL'					=> get_stylesheet_directory_uri(),
//		'PARENTPATH'					=> get_template_directory(),
//		'CHILDPATH'						=> get_stylesheet_directory(),
//		'GET_BLOGINFO_NAME'				=> get_option( 'blogname' ),
//		'GET_BLOGINFO_DESCRIPTION'		=> get_option( 'blogdescription' ),
//		'HOME_URL'						=> get_home_url( null, '/' ),
//		'PAGE_ON_FRONT'					=> absint( get_option( 'page_on_front' ) ),
//		'PAGE_FOR_POSTS'				=> absint( get_option( 'page_for_posts' ) ),

		yield self::THEME_NAME => (string)$this->theme->display( 'Name' );
		yield self::THEME_VERSION => (string)$this->theme->display( 'Version' );
		yield self::THEME_AUTHOR => (string)$this->theme->display( 'Author', false );
		yield self::TEMPLATE_DIR_URI	=> $this->theme->get_template_directory_uri();
		yield self::STYLESHEET_DIR_URI	=> $this->theme->get_stylesheet_directory_uri();
		yield self::TEMPLATE_DIR	=> $this->theme->get_template_directory();
		yield self::STYLESHEET_DIR => $this->theme->get_stylesheet_directory();
		yield self::THEME_BETA => false;
		yield self::VIEW_DIR => (string) $this->dispatcher->filter( 'italystrap_template_dir', 'templates' );
	}
}
