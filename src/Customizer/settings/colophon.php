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
 * Define a new section for Footer colophon
 * @var WP_Customize_Manager $manager
 */
$manager->add_section(
	'colophon',
	array(
		'title'				=> __( 'Footer\'s Colophon', 'italystrap' ),
		'description'		=> __( 'Add text for footer\'s colophon here', 'italystrap' ),
		'panel'				=> $this->panel, // Not typically needed.
		'priority'			=> 160,
		'capability'		=> $this->capability,
		'theme_supports'	=> '', // Rarely needed.
	)
);

/**
 * Add a textarea control for Colophon
 * @var WP_Customize_Manager $manager
 */
$manager->add_setting(
	'colophon',
	array(
		'default'			=> $this->theme_mods['colophon'],
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'wp_kses_post',
	)
);

/**
 * @var WP_Customize_Manager $manager
 */
$manager->add_control(
	'colophon',
	array(
			'label'			=> __( 'Footer\'s Colophon', 'italystrap' ),
			'description'	=> __( 'Add text for footer\'s colophon here', 'italystrap' ),
			'section'		=> 'colophon',
			'settings'		=> 'colophon',
			'priority'		=> 10,
			'type'			=> 'textarea',
		)
);


$manager->add_setting(
	'colophon_action',
	array(
		'default'			=> $this->theme_mods['colophon_action'],
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'refresh',
		'sanitize_callback'	=> 'wp_kses_post',
	)
);

$manager->add_control(
	'colophon_action',
	array(
			'label'			=> __( 'Footer\'s Colophon Position', 'italystrap' ),
			'description'	=> __( 'Add text for footer\'s colophon here', 'italystrap' ),
			'section'		=> 'colophon',
			'settings'		=> 'colophon_action',
			'priority'		=> 10,
			'type'			=> 'select',
			'choices'		=> apply_filters( 'italystrap_theme_positions', array() ),
		)
);

$manager->add_setting(
	'colophon_priority',
	array(
		'default'			=> $this->theme_mods['colophon_priority'],
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'refresh',
		'sanitize_callback'	=> 'wp_kses_post',
	)
);

$manager->add_control(
	'colophon_priority',
	array(
			'label'			=> __( 'Footer\'s Colophon Position', 'italystrap' ),
			'description'	=> __( 'Add text for footer\'s colophon here', 'italystrap' ),
			'section'		=> 'colophon',
			'settings'		=> 'colophon_priority',
			'priority'		=> 10,
			'type'			=> 'number',
		)
);
