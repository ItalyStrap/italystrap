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
 * Container Width of the header
 */
$manager->add_setting(
	'custom_header[container_width]',
	array(
		'default'			=> $this->theme_mods['custom_header']['container_width'],
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'refresh',
		'sanitize_callback'	=> 'sanitize_text_field',
	)
);

$manager->add_control(
	'italystrap_custom_header[container_width]',
	array(
		'label'		=> __( 'Container Width of the header', 'italystrap' ),
		'section'	=> 'header_image',
		'type'		=> 'select',
		'settings'	=> 'custom_header[container_width]',
		'choices'	=> array(
			// 'none'				=> __( 'None', 'italystrap' ),
			'container-fluid'	=> __( 'Full witdh', 'italystrap' ),
			'container'			=> __( 'Standard width', 'italystrap' ),
		),
	)
);
