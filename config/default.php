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

$theme_elements_config = array(
	'container'	=> 1170,
	'col'		=> 12,
	'gutter'	=> 30,
);

$container = 1170;
$gutter = 30;
$col = 12;

return array(

	/**
	 * Future improvement
	 */
	'theme_support'				=> array(
		'supported_post_type'	=> array(
			 'page',
			 'post',
			 'download',
			 'product',
			 'forum',
			 'topic',
			 'reply',
		)
	),
	'post_type_support'			=> array(
		'post'		=> array( 'post_navigation', 'entry-meta' ),
		'page'		=> array( 'post_navigation', 'entry-meta' ),
		// 'product'	=> array( 'post_navigation', 'entry-meta' ), // WOO usa i suoi template quindi forse non è necessario.
		'download'	=> array( 'post_navigation', 'entry-meta' ),
	),

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

	'custom_header'					=> array(
		'container_width'	=> 'container',
	),

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
	'logo'							=> TEMPLATEURL . '/img/italystrap-logo.jpg',
	'default_image'					=> TEMPLATEURL . '/img/italystrap-default-image.png',
	'default_404'					=> TEMPLATEURL . '/img/404.jpg',

	'post_thumbnail_size'			=> 'post-thumbnail',
	'post_thumbnail_alignment'		=> 'alignnone',

	/**
	 * Navbar
	 */
	'display_navbar_brand'			=> 'display_name',
	'navbar_logo_image'				=> '',
	'navbar_logo_image_size'		=> 'navbar-brand-image',
	// 'display_navbar_logo_image'		=> '',
	// 'display_navbar_logo_image'		=> '',
	'navbar'						=> array(
		'type'			=> 'navbar-default',
		'position'		=> 'navbar-relative-top',
		'nav_width'		=> 'container', // This is the container of entire navbar.
		'menus_width'	=> 'container-fluid', // This is the container of the 2 menus inside the nav container and the navbar_header brand and toggle.
	),

	/**
	 * Default text for colophon
	 */
	'colophon'						=> apply_filters( 'italystrap_colophon_default_text', Core\colophon_default_text() ),

	/**
	 * Layout configuration
	 * It's still in alpha version
	 */
	'site_layout'					=> 'content_sidebar',
	'singular_layout'				=> 'content_sidebar',
	'content_width'					=> Core\get_content_width( 1170, 12, 8, 30 ),
	'container_class'				=> 'container', // container-fluid.
	'content_class'					=> 'col-md-8', // 7 - 6.
	'sidebar_class'					=> 'col-md-4', // 3 - 3.
	'sidebar_secondary_class'		=> '', // 2 - 3.
	'full_width'					=> 'col-md-12',

	'layout'						=> array(
		'choices'	=> array(
			// 'none'				=> __( 'None', 'italystrap' ),
			'container-fluid'	=> __( 'Full witdh', 'italystrap' ),
			'container'			=> __( 'Standard width', 'italystrap' ),
		)
	),

	'post_content_template'			=> '',

	/**
	 * Display image size 740x370 in single and page
	 */
	// add_image_size( 'article-thumb', 740, 370, true);
	/**
	 * Display image size 253x126 in index and correlated
	 */
	// add_image_size( 'article-thumb-index', 253, 126, true);
	/**
	 * Display image size 1130x565 in full-width page
	 */
	// add_image_size( 'full-width', 1140, 9999 );

	/**
	 * Image size displayed in the navbar brand image
	 *
	 * @see Class Navbar::get_navbar_brand()
	 */
	// add_image_size( 'navbar-brand-image', 45, 45, true);

	/**
	 * col-md-12 1140
	 * col-md-11 1043
	 * col-md-10 945
	 * col-md-9 848
	 * col-md-8 750
	 * col-md-7 653
	 * col-md-6 555
	 * col-md-5 458
	 * col-md-4 360
	 * col-md-3 263
	 * col-md-2 165
	 * col-md-1 68
	 */

	/**
	 * Set the default image
	 * @link http://codex.wordpress.org/Function_Reference/add_image_size
	 */
	'image_size'					=> array(
		'navbar-brand-image'	=> array(
			'width'		=> 45,
			'height'	=> 45,
			'crop'		=> true,
		),
		/**
		 * La full-width serve solo per la pagina omonima
		 * Si potrebbe invece settare "large" a 1140 (verificare se 1170 va bene) e risparmiare spazio avendo una immagine di meno poichè entrambe non vengono croppate
		 * "large" può essere settata anche con altezza a 9999
		 */
		'full-width'			=> array(
			'width'		=> $container - $gutter,
			'height'	=> 9999,
			'crop'		=> false,
		),
		'one_half'			=> array(
			'width'		=> $container / 2 - $gutter,
			'height'	=> ($container / 2 - $gutter) * 3 / 4,
			'crop'		=> true,
		),
		'one_third'			=> array(
			'width'		=> $container / 3 - $gutter,
			'height'	=> ($container / 3 - $gutter) * 3 / 4,
			'crop'		=> true,
		),
		'one_fourth'			=> array(
			'width'		=> $container / 4 - $gutter,
			'height'	=> ($container / 4 - $gutter) * 3 / 4,
			'crop'		=> true,
		),
		'one_six'			=> array(
			'width'		=> $container / 6 - $gutter,
			'height'	=> ($container / 6 - $gutter) * 3 / 4,
			'crop'		=> true,
		),
	),


	/**
	 * @todo Valutare l'utilizzo delle frazioni e creare:
	 * un_mezzo
	 * un_terzo
	 * un_quarto
	 * un_sesto
	 * direi che queste siano più che sufficienti
	 * Il calcolo si può fare:
	 * 1170 / 4 - gutter(30) e ottengo un_quarto
	 * 
	 * add_image_size( 'one_fourth', 263, 238, true );
	 *
	 * l'altezza proporzionata si calcola:
	 * 4/3
	 * $width : 4 = $height : 3
	 * $width * 3 / 4;
	 */
	'breakpoint'					=> array(
		// 'xs'	=> 480,
		// 'sm'	=> 768,
		// 'md'	=> 992,
		// 'lg'	=> 1200,
	),

	/**
	 * Content
	 * @deprecated Moved to the plugin
	 */
	// 'excerpt_length'				=> 25,
	// 'read_more_class'				=> 'read-more',
	// 'read_more_link'				=> ' <a href="%1$s" class="%2$s"> &hellip; %3$s</a>',
	// 'read_more_link_text'			=> __( '&hellip; Read more', 'italystrap' ),

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
