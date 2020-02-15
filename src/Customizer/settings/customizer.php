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
 * Let's make some stuff use live preview JS...
 */
$manager->get_setting( 'blogname' )->transport = 'postMessage';
$manager->get_setting( 'blogdescription' )->transport = 'postMessage';

/**
 * Add new panel for ItalyStrap theme options
 */
$manager->add_panel(
	$this->panel,
	array(
		'title'			=> sprintf(
			__( '%s Options', 'italystrap' ),
			ITALYSTRAP_CURRENT_THEME_NAME
		),
		// 'description'	=> 'add_panel', // Include html tags such as <p>.
		// 'priority'		=> 160, // Mixed with top-level-section hierarchy.
		'priority'		=> 10, // Mixed with top-level-section hierarchy.
	)
);
