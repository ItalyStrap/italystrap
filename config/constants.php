<?php
declare(strict_types=1);

namespace ItalyStrap;

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

$current_theme_name = wp_get_theme()->get( 'Name' );
$prefix = strtolower( strval( $current_theme_name ) );

$get_template = get_template();

return apply_filters(
	'italystrap_default_theme_constants',
	[
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
	]
);
