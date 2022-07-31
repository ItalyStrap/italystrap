<?php
/**
 * Define default theme constant
 *
 * Define default constant to use in the theme framework
 *
 * @since 4.0.0
 *
 * @package ItalyStrap\Core
 */
declare(strict_types=1);

namespace ItalyStrap\Core;

use function define;
use function defined;

use function absint;
use function get_home_url;
use function get_option;
use function get_stylesheet_directory;
use function get_stylesheet_directory_uri;
use function get_template;
use function get_template_directory;
use function get_template_directory_uri;
use function strtolower;
use function strval;
use function wp_get_theme;

/**
 * Set default constant
 * @param array $constant
 * @return array
 */
function set_default_constants( array $constant = [] ): array {

	$current_theme_name = wp_get_theme()->get( 'Name' );
	$prefix = strtolower( strval( $current_theme_name ) );

	$get_template = get_template();

//		\define( 'ITALYSTRAP_THEME', true);
//		\define( 'ITALYSTRAP_THEME_NAME', wp_get_theme( $get_template )->display( 'Name' ));
//		\define( 'ITALYSTRAP_THEME_VERSION', wp_get_theme( $get_template )->display( 'Version' ));
//		\define( 'ITALYSTRAP_THEME_AUTHOR', wp_get_theme( $get_template )->display( 'Author', false ));
//		\define( 'ITALYSTRAP_CURRENT_THEME_NAME', $current_theme_name);
//		\define( 'PREFIX', $prefix);
//		\define( '_PREFIX', '_' . $prefix);
//		\define( 'TEMPLATEURL', get_template_directory_uri());
//		\define( 'STYLESHEETURL', get_stylesheet_directory_uri());
//		\define( 'PARENTPATH', get_template_directory());
//		\define( 'CHILDPATH', get_stylesheet_directory());
//	! defined( 'GET_BLOGINFO_NAME' ) && \define( 'GET_BLOGINFO_NAME', get_option( 'blogname' ));
//	! defined( 'GET_BLOGINFO_DESCRIPTION' ) && \define( 'GET_BLOGINFO_DESCRIPTION', get_option( 'blogdescription' ));
//	! defined( 'HOME_URL' ) && \define( 'HOME_URL', get_home_url( null, '/' ));
//		\define( 'PAGE_ON_FRONT', absint( get_option( 'page_on_front' ) ));
//		\define( 'PAGE_FOR_POSTS', absint( get_option( 'page_for_posts' ) ));

//	foreach ( $constant as $name => $value ) {
//		if ( ! defined( $name ) ) {
//			define( $name, $value );
//		}
//	}

	return $constant;
}
