<?php
/**
 * Default configuration file
 *
 * All dafault configuration for ItalyStrap -framework
 *
 * @link [URL]
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Customizer;

use ItalyStrap\Core;

return array(

	/**
	 * Color section
	 */
	'background_color'				=> '', // Set by WordPress.
	'header_textcolor'				=> '', // Set by WordPress.
	'link_textcolor'				=> '',
	'hx_textcolor'					=> '',

	/**
	 * Header image
	 */
	'header_image'					=> '', // Set by WordPress.

	/**
	 * Background image
	 */
	'background_image'				=> '', // Set by WordPress.
	'background_repeat'				=> 'no-repeat', // Set by WordPress.
	'background_position_x'			=> 'center', // Set by WordPress.

	/**
	 * Default images
	 */
	'logo'							=> TEMPLATEURL . '/img/italystrap-logo.jpg',
	'display_navbar_brand'			=> 'display_name',
	'navbar_logo_image'				=> '',
	'navbar_logo_image_size'		=> 'navbar-brand-image',
	// 'display_navbar_logo_image'		=> '',
	'default_image'					=> TEMPLATEURL . '/img/italystrap-default-image.png',
	'default_404'					=> TEMPLATEURL . '/img/404.jpg',

	/**
	 * Default text for colophon
	 */
	'colophon'						=> apply_filters( 'italystrap_colophon_default_text', Core\colophon_default_text() ),

	/**
	 * Layout configuration
	 * It's still in alpha version
	 */
	'site_layout'					=> 'content_sidebar',
	'content_width'					=> Core\get_content_width( 1170, 12, 8, 30 ),
	'container_class'				=> 'container', // container-fluid.
	'content_class'					=> 'col-md-8', // 7 - 6.
	'sidebar_class'					=> 'col-md-4', // 3 - 3.
	'sidebar_secondary_class'		=> '', // 2 - 3.
	'full_width'					=> 'col-md-12',

	/**
	 * Set the default image
	 */
	'default_image_size'			=> array(
		'navbar-brand-image'	=> array(
			'width'		=> 45,
			'height'	=> 45,
			'crop'		=> true,
		),
		'full-width'			=> array(
			'width'		=> 1140,
			'height'	=> 9999,
			'crop'		=> false,
		),
	),

	'breakpoint'					=> array(
		'xs'	=> 480,
		'sm'	=> 768,
		'md'	=> 992,
		'lg'	=> 1200,
	),

	/**
	 * Set by plugin
	 */
	// 'custom_css'					=> '',
	// 'analytics'						=> '',
	// 'first_font_family'				=> '',
	// 'first_font_variants'			=> '',
	// 'first_font_subsets'			=> '',
	// 'activate_custom_css'			=> '',
	// 'body_class'					=> '',
	// 'post_class'					=> '',

);
