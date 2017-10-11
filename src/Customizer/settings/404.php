<?php
/**
 * Customizer settings for 404 page
 *
 * @link http://italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Customizer\Control;

use WP_Customize_Media_Control;

/**
 * Define a new section for theme image options
 */
$manager->add_section(
	'italystrap_404',
	array(
		'title'			=> __( '404 Page', 'italystrap' ),
		'panel'			=> $this->panel,
		'capability'	=> $this->capability,
		'description'	=> __( 'Customize the 404 page for this theme.', 'italystrap' ),
	)
);

$manager->add_setting(
	'404_show_image',
	array(
		'default'			=> $this->theme_mods['404_show_image'],
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'sanitize_text_field',
	)
);

$manager->add_control(
	'italystrap_404_show_image',
	array(
		'label'			=> __( '404 Page Text', 'italystrap' ),
		'description'	=> __( 'The text for the content for the 404 page.', 'italystrap' ),
		'section'		=> 'italystrap_404',
		'settings'		=> '404_show_image',
		'priority'		=> 10,
		'type'			=> 'select',
		'choices'		=> array(
			'show'	=> __( 'Show the 404 image', 'italystrap' ),
			'hide'	=> __( 'Hide the 404 image', 'italystrap' ),
		),
	)
);


$manager->add_setting(
	'404_image',
	array(
		'default'			=> $this->theme_mods['404_image'],
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'sanitize_text_field',
	)
);

$manager->add_control(
	new WP_Customize_Media_Control(
		$manager,
		'italystrap_404_image',
		array(
			'label'			=> __( 'Default 404 Image', 'italystrap' ),
			'description'	=> sprintf(
				__( 'This is a default 404 image, it will be displayed in 404 page (must be at least %dpx width)', 'italystrap' ),
				$this->theme_mods['content_width']
			),
			'section'		=> 'italystrap_404',
			'settings'		=> '404_image',
			'priority'		=> 10,
		)
	)
);

$manager->add_setting(
	'404_title',
	array(
		'default'			=> $this->theme_mods['404_title'],
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'sanitize_text_field',
	)
);

$manager->add_control(
	'italystrap_404_title',
	array(
		'label'			=> __( '404 Page Title', 'italystrap' ),
		'description'	=> __( 'Add a title for the 404 page.', 'italystrap' ),
		'section'		=> 'italystrap_404',
		'settings'		=> '404_title',
		'priority'		=> 10,
		'type'			=> 'text',
	)
);

$manager->add_setting(
	'404_content',
	array(
		'default'			=> $this->theme_mods['404_content'],
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'sanitize_text_field',
	)
);

$manager->add_control(
	'italystrap_404_content',
	array(
		'label'			=> __( '404 Page Text', 'italystrap' ),
		'description'	=> __( 'The text for the content for the 404 page.', 'italystrap' ),
		'section'		=> 'italystrap_404',
		'settings'		=> '404_content',
		'priority'		=> 10,
		'type'			=> 'textarea',
	)
);
