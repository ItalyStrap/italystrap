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
 * Define a new section for cusom CSS
 */
$manager->add_section(
	'custom_css',
	array(
		'title'				=> __( 'Additional CSS', 'italystrap' ),
		'description'		=> __( 'Add custom CSS here', 'italystrap' ),
		'panel'				=> $this->panel, // Not typically needed.
		'priority'			=> 160,
		'capability'		=> $this->capability,
		'theme_supports'	=> '', // Rarely needed.
	)
);

/**
 * Add a textarea control for custom css
 */
$manager->add_setting(
	'custom_css',
	array(
		'default'			=> $this->theme_mods['custom_css'],
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'refresh',
		'sanitize_callback'	=> 'sanitize_text_field',
	)
);

$manager->add_control(
	new Textarea(
		$manager,
		'custom_css',
		array(
			'label'			=> __( 'Custom CSS', 'italystrap' ),
			'description'	=> __( 'Insert here your custom CSS', 'italystrap' ),
			'section'		=> 'custom_css',
			'settings'		=> 'custom_css',
			'priority'		=> 10,
		)
	)
);
