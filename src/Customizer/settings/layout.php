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
$manager->add_section(
	'italystrap_layout_options',
	array(
		'title'			=> __( 'Layout', 'italystrap' ), // Visible title of section.
		'panel'			=> $this->panel,
		'capability'	=> $this->capability,
		'description'	=> __( 'Allows you to customize the layout for all archive type pages. (Not page and post).', 'italystrap' ),
	)
);

/**
 * Container Width of the header
 */
$manager->add_setting(
	'site_layout',
	array(
		// 'default'			=> $this->theme_mods['_site_layout_header']['container_width'],
		'default'			=> 'content_sidebar',
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'refresh',
		'sanitize_callback'	=> 'sanitize_text_field',
	)
);

$manager->add_control(
	'italystrap_site_layout',
	array(
		'label'		=> __( 'Layout (Global)', 'italystrap' ),
		'section'	=> 'italystrap_layout_options',
		'type'		=> 'radio',
		'settings'	=> 'site_layout',
		'choices'	=> require PARENTPATH . '/config/layout.php',
	)
);
