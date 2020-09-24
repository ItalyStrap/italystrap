<?php
declare(strict_types=1);

namespace ItalyStrap\Customizer;

use ItalyStrap\Config\ConfigInterface;

/** @var ConfigInterface $mods */
$mods = $this->theme_mods;

/**
 * Container Width of the header
 * @var \WP_Customize_Manager $manager
 */
$manager->add_setting(
	'custom_header[container_width]',
	array(
		'default'			=> $mods->get('custom_header.container_width'),
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
