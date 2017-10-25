<?php
/**
 * Settings for Customizer
 *
 * @link https://github.com/WPTRT/code-examples
 *
 * @package ItalyStrap
 * @since 4.0.0
 */

namespace ItalyStrap\Customizer;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

use WP_Customize_Manager;
use WP_Customize_Control;
use WP_Customize_Color_Control;
use	WP_Customize_Media_Control;

use ItalyStrap\Core as Core;
use	ItalyStrap\Customizer\Control\Textarea;

/**
 * Define a new section for theme image options
 */
$manager->add_section(
	'italystrap_image_options',
	array(
		'title'			=> __( 'Image', 'italystrap' ),
		'panel'			=> $this->panel,
		'capability'	=> $this->capability,
		'description'	=> __( 'Allows you to customize settings for ItalyStrap.', 'italystrap' ),
	)
);

/**
 * Register new settings to the WP database...
 */
$manager->add_setting(
	'logo',
	array(
		'default'			=> $this->theme_mods['logo'],
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'sanitize_text_field',
	)
);

$manager->add_control(
	new WP_Customize_Media_Control(
		$manager,
		'italystrap_logo',
		array(
			'label'			=> __( 'Your Logo', 'italystrap' ),
			'description'	=> __( 'Insert here your logo', 'italystrap' ),
			'section'		=> 'italystrap_image_options',
			'settings'		=> 'logo',
			'priority'		=> 10,
		)
	)
);

/**
 * Set a default image to use in:
 * the_thumbnail
 */
$manager->add_setting(
	'default_image',
	array(
		'default'			=> $this->theme_mods['default_image'],
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'sanitize_text_field',
	)
);

$manager->add_control(
	new WP_Customize_Media_Control(
		$manager,
		'italystrap_default_image',
		array(
			'label'			=> __( 'Default Image', 'italystrap' ),
			'description'	=> __( 'Upload an image for the default image used for social sharing (must be at least 1200x600px for Facebook), it will also be displayed if no feautured image will be added in your content page/post if the theme supports this feature.', 'italystrap' ),
			'section'		=> 'italystrap_image_options',
			'settings'		=> 'default_image',
			'priority'		=> 10,
		)
	)
);

/**
 * Change image size of post thumbnail in archive, author, blog, category, search, and tag pages. 
 */
$manager->add_setting(
	'post_thumbnail_size',
	array(
		'default'			=> $this->theme_mods['post_thumbnail_size'],
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'refresh',
		'sanitize_callback'	=> 'sanitize_text_field',
	)
);
$manager->add_control(
	'italystrap_post_thumbnail_size',
	array(
		'settings'		=> 'post_thumbnail_size',
		'label'			=> __( 'Archive post thumbnail size', 'italystrap' ),
		'description'	=> __( 'Change image size of post thumbnail in archive, author, blog, category, search, and tag pages.', 'italystrap' ),
		'section'		=> 'italystrap_image_options',
		'type'			=> 'select',
		'choices'		=> $this->size->get_image_sizes(),
	)
);

/**
 * Change image alignment of post thumbnail in archive, author, blog, category, search, and tag pages.
 */
$manager->add_setting(
	'post_thumbnail_alignment',
	array(
		'default'			=> $this->theme_mods['post_thumbnail_alignment'],
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'refresh',
		'sanitize_callback'	=> 'sanitize_text_field',
	)
);
$manager->add_control(
	'italystrap_post_thumbnail_alignment',
	array(
		'settings'		=> 'post_thumbnail_alignment',
		'label'			=> __( 'Archive post thumbnail alignment', 'italystrap' ),
		'description'	=> __( 'Change image alignment of post thumbnail in archive, author, blog, category, search, and tag pages.', 'italystrap' ),
		'section'		=> 'italystrap_image_options',
		'type'			=> 'select',
		'choices'		=> array(
			'alignnone'		=> __( 'None', 'italystrap' ),
			'aligncenter'	=> __( 'Center', 'italystrap' ),
			'alignleft'		=> __( 'Left', 'italystrap' ),
			'alignright'	=> __( 'Right', 'italystrap' ),
		),
	)
);

