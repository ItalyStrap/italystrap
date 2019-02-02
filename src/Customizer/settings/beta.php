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
 * Define a new section for Footer beta
 */
$manager->add_section(
	'beta',
	array(
		'title'				=> __( 'Beta version', 'italystrap' ),
//		'description'		=> __( 'Add text for footer\'s beta here', 'italystrap' ),
		'panel'				=> $this->panel, // Not typically needed.
		'priority'			=> 160,
		'capability'		=> $this->capability,
		'theme_supports'	=> '', // Rarely needed.
	)
);

/**
 * Add a textarea control for Colophon
 */
$manager->add_setting(
	'beta',
	array(
		'default'			=> $this->theme_mods['beta'],
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'wp_kses_post',
	)
);

$manager->add_control(
	'beta',
	array(
		'label'			=> __( 'Beta version', 'italystrap' ),
//		'description'	=> __( 'Add text for footer\'s beta here', 'italystrap' ),
		'section'		=> 'beta',
		'settings'		=> 'beta',
		'priority'		=> 10,
		'type'			=> 'checkbox',
	)
);