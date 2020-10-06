<?php
declare(strict_types=1);

namespace ItalyStrap\Customizer;

use WP_Customize_Manager;
use WP_Customize_Control;
use WP_Customize_Color_Control;
use	WP_Customize_Media_Control;

use ItalyStrap\Core as Core;
use	ItalyStrap\Customizer\Control\Textarea;

/**
 * Define a new section for theme image options
 */
/** @var \WP_Customize_Manager $manager */
$manager->add_section(
	'italystrap_layout_options',
	[
		'title'			=> __( 'Layout', 'italystrap' ), // Visible title of section.
		'panel'			=> $this->panel,
		'capability'	=> $this->capability,
		// phpcs:disable
		'description'	=> __( 'Allows you to customize the layout for all archive type pages. (Not page and post).', 'italystrap' ),
		// phpcs:enable
	]
);

/**
 * Container Width
 */
$manager->add_setting(
	'container_width',
	[
		'default'			=> $this->theme_mods->get('container_width'),
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'refresh',
		'sanitize_callback'	=> 'sanitize_text_field',
	]
);

$manager->add_control(
	'italystrap_container_width',
	[
		'label'		=> __( 'Container width (Global)', 'italystrap' ),
		'section'	=> 'italystrap_layout_options',
		'type'		=> 'radio',
		'settings'	=> 'container_width',
		'choices'	=> apply_filters( 'italystrap_theme_width', [] ),
	]
);

/**
 * Container Width of the header
 */
$manager->add_setting(
	'site_layout',
	[
		'default'			=> $this->theme_mods->get('content_sidebar'),
	//		'default'			=> 'content_sidebar',
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'refresh',
		'sanitize_callback'	=> 'sanitize_text_field',
	]
);

$manager->add_control(
	'italystrap_site_layout',
	[
		'label'		=> __( 'Layout (Global)', 'italystrap' ),
		'section'	=> 'italystrap_layout_options',
		'type'		=> 'radio',
		'settings'	=> 'site_layout',
		'choices'	=> require PARENTPATH . '/config/layout.php',
	]
);
