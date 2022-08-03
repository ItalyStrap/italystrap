<?php
declare(strict_types=1);

namespace ItalyStrap\Customizer;

use ItalyStrap\Config\ConfigColorSectionProvider;
use WP_Customize_Color_Control;

/** @var \WP_Customize_Manager $manager */
$manager->get_setting(  ConfigColorSectionProvider::HEADER_COLOR )->transport = 'postMessage';
$manager->get_setting(  ConfigColorSectionProvider::BG_COLOR )->transport = 'postMessage';

/**
 * Changing Customizer Color Sections Titles
 */
// $manager->get_section( 'colors' )->title = __( 'Theme Colors', 'italystrap' );

/**
 * 2. Register new settings to the WP database...
 */
$id_link_color = ConfigColorSectionProvider::LINK_COLOR;
$manager->add_setting(
	$id_link_color, // No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record.
	array(
		'default'			=> $this->theme_mods[$id_link_color], // Default setting/value to save.
		'type'				=> 'theme_mod', // Is this an 'option' or a 'theme_mod'?
		'capability'		=> $this->capability, // Optional. Special permissions for accessing this setting.
		// What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'sanitize_hex_color',
		)
);

/**
 * 3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
 */
$manager->add_control(
	new WP_Customize_Color_Control( // Instantiate the color control class
		$manager, // Pass the $manager object (required).
		"italystrap_{$id_link_color}", // Set a unique ID for the control.
		array(
			'label'		=> __( 'Link Color', 'italystrap' ), // Admin-visible name of the control.
			// ID of the section this control should render in (can be one of yours, or a WordPress default section).
			'section'	=> 'colors',
			'settings'	=> $id_link_color, // Which setting to load and manipulate (serialized is okay).
			'priority'	=> 10, // Determines the order this control appears in for the specified section.
		)
	)
);

$id_hx_color = ConfigColorSectionProvider::HX_COLOR;
$manager->add_setting(
	$id_hx_color,
	array(
		'default'			=> $this->theme_mods[$id_hx_color],
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'sanitize_hex_color',
	)
);

$manager->add_control(
	new WP_Customize_Color_Control(
		$manager,
		'italystrap_' . $id_hx_color,
		array(
			'label'		=> __( 'Heading Color', 'italystrap' ),
			'section'	=> 'colors',
			'settings'	=> $id_hx_color,
			'priority'	=> 10,
		)
	)
);
