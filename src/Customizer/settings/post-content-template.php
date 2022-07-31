<?php
declare(strict_types=1);

namespace ItalyStrap\Customizer\Control;

if ( ! class_exists( '\ItalyStrap\Customizer\Control\Multicheck' ) ) {
	return;
}
/** @var \WP_Customize_Manager $manager */

/**
 * Define a new section for theme image options
 */
$manager->add_section(
	'italystrap_post_content_template_options',
	[
		'title'			=> __( 'Post content template', 'italystrap' ),
		'panel'			=> $this->panel,
		'capability'	=> $this->capability,
		'description'	=>
			__(
				'Allows you to customize the post content template for all archive type pages. (Not page and post).',
				'italystrap'
			),
	]
);

/**
 * Container Width of the header
 */
$manager->add_setting(
	'post_content_template',
	array(
		// 'default'			=> $this->theme_mods['_post_content_template_header']['container_width'],
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'sanitize_text_field',
	)
);

$manager->add_control(
	new Multicheck(
		$manager,
		'italystrap_post_content_template',
		array(
			'label'		=> __( 'Template content settings', 'italystrap' ),
			'section'	=> 'italystrap_post_content_template_options',
			'type'		=> 'multicheck',
			'settings'	=> 'post_content_template',
			'choices'	=> require \get_template_directory() . '/config/template-content.php',
		)
	)
);
