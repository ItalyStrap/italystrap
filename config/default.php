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
declare(strict_types=1);

namespace ItalyStrap;

use function ItalyStrap\Core\{colophon_default_text,get_content_width};

$config = Factory\get_config();

return apply_filters(
	'italystrap_default_theme_config',
	[
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

		'custom_header'					=> [
			'container_width'	=> 'container',
		],

		/**
		 * Background image
		 */
		'background_image'				=> '', // Set by WordPress.
		'background_repeat'				=> 'no-repeat', // Set by WordPress.
		'background_position_x'			=> 'center', // Set by WordPress.

		'custom_css'					=> '',

		/**
		 * Default images
		 */
		'logo'							=> $config->TEMPLATEURL . '/assets/img/logo.png',
		'default_image'					=> $config->TEMPLATEURL . '/assets/img/italystrap-default-image.png',
		'default_404'					=> $config->TEMPLATEURL . '/assets/img/404.png',
		'404_show_image'				=> 'show',
		'404_image'						=> '',
		'404_title'						=> esc_attr__( 'Nothing Found', 'italystrap' ),
		'404_content'					=> esc_attr__( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'italystrap' ),

		'post_thumbnail_size'			=> 'post-thumbnail',
		'post_thumbnail_alignment'		=> 'alignnone',

		/**
		 * ==========================================================
		 *
		 * Navbar
		 *
		 * ==========================================================
		 */
		'display_navbar_brand'			=> 'display_name',
		'navbar_logo_image'				=> '',
		'navbar_logo_image_size'		=> 'navbar-brand-image',
		'navbar_logo_image_mobile'		=> null,
		// 'display_navbar_logo_image'		=> '',
		// 'display_navbar_logo_image'		=> '',
		'navbar'						=> [
			/**
			 * options:
			 * navbar-default
			 * navbar-inverse
			 */
			'type'			=> 'navbar-inverse',
			'position'		=> 'navbar-static-top',
			'nav_width'		=> 'none', // This is the container of entire navbar.
			'menus_width'	=> 'container', // This is the container of the 2 menus inside the nav container and the navbar_header brand and toggle.
		],

		/**
		 * Default text for colophon
		 */
		'colophon'						=> colophon_default_text(),
		'colophon_action'				=> 'italystrap_footer',
		'colophon_priority'				=> 20,

		/**
		 * Layout configuration
		 * It's still in alpha version
		 */
//		'site_layout'					=> 'content_sidebar',
		//( is_customize_preview() ? get_theme_mod('site_layout') : $this->theme_mods['site_layout'] );
		// https://core.trac.wordpress.org/ticket/24844
		'site_layout'					=> (string) \apply_filters( 'theme_mod_site_layout', 'content_sidebar' ),
		'singular_layout'				=> 'content_sidebar',
		'content_width'					=> (int) \apply_filters( 'italystrap_content_width',
			get_content_width(
				1170,
				12,
				8,
				30
			)
		),
		'container_width'				=> 'container', // container-fluid.
		'container_class'				=> 'container', // container-fluid. // @TODO maybe not used
		'content_class'					=> 'col-md-8', // 7 - 6.
		'sidebar_class'					=> 'col-md-4', // 3 - 3.
		'sidebar_secondary_class'		=> '', // 2 - 3.
		'full_width'					=> 'col-md-12',

		'layout'						=> [
			'choices'	=> [
				// 'none'				=> \__( 'None', 'italystrap' ),
				'container-fluid'	=> \__( 'Full witdh', 'italystrap' ),
				'container'			=> \__( 'Standard width', 'italystrap' ),
			]
		],

		'post_content_template'			=> '',
		'breadcrumbs_show_on'			=> '',

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

		'beta'	=> false,

		'template_dir'	=> (string) \apply_filters( 'italystrap_template_dir', 'templates' ),
	]
);
