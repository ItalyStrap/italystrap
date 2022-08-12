<?php
/**
 * Customizer configuration file
 *
 * [Long Description.]
 *
 * @link [URL]
 * @since 4.0.0
 *
 * @package ItalyStrap\Customizer
 */

declare(strict_types=1);

namespace ItalyStrap\Customizer;

use WP_Customize_Manager;
use WP_Customize_Control;
use WP_Customize_Color_Control;
use	WP_Customize_Media_Control;

use ItalyStrap\Core as Core;
use	ItalyStrap\Customizer\Control\Textarea;

return [

	/**
	 * The panel name id
	 */
	'italystrap_options_page' => [
		'type'		=> 'panel',
		'args'		=> [
			'priority'			=> 10,
			'capability'		=> $this->capability,
			'theme_supports'	=> '',
			'title'				=> __( 'Theme settings', 'italystrap' ),
			'description'		=> 'This is the settings panel for ItalyStrap',
		],
		'sections'	=> [
			/**
			 * Section ID
			 */
			'italystrap_image_options'	=> [
				/**
				 * Section arguments
				 */
				'args'	=> [
					'title'			=> __( 'Theme Image Options', 'italystrap' ),
					// 'panel'			=> 'italystrap_options_page',
					'capability'	=> $this->capability,
					'description'	=> __( 'Allows you to customize settings for ItalyStrap.', 'italystrap' ),
				],
				'config' => [

					'logo' => [
						'setting'	=> 	[
							'default' => \get_template_directory_uri() . '/img/italystrap-logo.jpg',
							// 'type' => 'theme_mod',
							// 'capability' => $this->capability,
							// 'transport' => 'postMessage',
							// 'sanitize_callback' => 'sanitize_text_field',
						],
						'control'	=> 	new WP_Customize_Media_Control(
							$manager,
							'italystrap_logo',
							[
								'label' => __( 'Your Logo', 'italystrap' ),
								'description' => __( 'Insert here your logo', 'italystrap' ),
								'section' => 'italystrap_image_options',
								'settings' => 'logo',
								'priority' => 10,
							]
						),

					],
				],
			], // End 'italystrap_image_options'
		], // End section id
	],

	/**
	 * The section name
	 */
	// 'color'	=> array(
	// 	'type'	=> 'section',
	// 	'args'	=> array(

	// 	),
	// ),

	/**
	 * Section for image option
	 */
	// 'italystrap_image_options' => array(
	// 	'title' => __( 'Theme Image Options', 'italystrap' ), // Visible title of section.
	// 	'panel' => $this->panel,
	// 	'capability' => $this->capability,
	// 	'description' => __( 'Allows you to customize settings for ItalyStrap.', 'italystrap' ),
	// ),


];
