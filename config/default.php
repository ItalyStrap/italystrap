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
	'link_textcolor'				=> '#337ab7',
	'hx_textcolor'					=> '#333',

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
	'navbar_logo_image'				=> '',
	'navbar_logo_image_size'		=> 'navbar-brand-image',
	'display_navbar_logo_image'		=> '',
	'default_image'					=> TEMPLATEURL . '/img/italystrap-default-image.png',
	'default_404'					=> TEMPLATEURL . '/img/404.jpg',

	/**
	 * Default text for colophon
	 */
	'colophon'						=> apply_filters( 'italystrap_colophon_default_text', Core\colophon_default_text() ),

	'content_width'					=> 750,

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
