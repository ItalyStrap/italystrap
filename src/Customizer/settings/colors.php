<?php
declare(strict_types=1);

namespace ItalyStrap\Customizer;

use WP_Customize_Manager;
use WP_Customize_Control;
use WP_Customize_Color_Control;
use	WP_Customize_Media_Control;

use ItalyStrap\Core as Core;
use	ItalyStrap\Customizer\Control\Textarea;

$manager->get_setting( 'header_textcolor' )->transport = 'postMessage';
$manager->get_setting( 'background_color' )->transport = 'postMessage';

/**
 * Changing Customizer Color Sections Titles
 */
// $manager->get_section( 'colors' )->title = __( 'Theme Colors', 'italystrap' );

/**
 * 2. Register new settings to the WP database...
 */
$manager->add_setting(
	'link_textcolor', // No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record.
	array(
		'default'			=> $this->theme_mods['link_textcolor'], // Default setting/value to save.
		'type'				=> 'theme_mod', // Is this an 'option' or a 'theme_mod'?
		'capability'		=> $this->capability, // Optional. Special permissions for accessing this setting.
		'transport'			=> 'postMessage', // What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
		'sanitize_callback'	=> 'sanitize_hex_color',
		)
);

/**
 * 3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
 */
$manager->add_control(
	new WP_Customize_Color_Control( // Instantiate the color control class
		$manager, // Pass the $manager object (required).
		'italystrap_link_textcolor', // Set a unique ID for the control.
		array(
			'label'		=> __( 'Link Color', 'italystrap' ), // Admin-visible name of the control.
			'section'	=> 'colors', // ID of the section this control should render in (can be one of yours, or a WordPress default section).
			'settings'	=> 'link_textcolor', // Which setting to load and manipulate (serialized is okay).
			'priority'	=> 10, // Determines the order this control appears in for the specified section.
		)
	)
);

/**
 * Hx font color
 */
$manager->add_setting(
	'hx_textcolor',
	array(
		'default'			=> $this->theme_mods['hx_textcolor'],
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'sanitize_hex_color',
	)
);

$manager->add_control(
	new WP_Customize_Color_Control(
		$manager,
		'italystrap_hx_textcolor',
		array(
			'label'		=> __( 'Heading Color', 'italystrap' ),
			'section'	=> 'colors',
			'settings'	=> 'hx_textcolor',
			'priority'	=> 10,
		)
	)
);
