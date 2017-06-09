<?php
/**
 * Customizer settings for template parts
 *
 * Setting
 *
 * @link http://italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Customizer\Control;

/**
 * Define a new section for theme image options
 */
$manager->add_section(
	'italystrap_post_content_template_options',
	array(
		'title'			=> __( 'Post content template', 'italystrap' ),
		'panel'			=> $this->panel,
		'capability'	=> $this->capability,
		'description'	=> __( 'Allows you to customize the post content template for all archive type pages. (Not page and post).', 'italystrap' ),
	)
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
			'label'		=> __( 'Container Width of the header', 'italystrap' ),
			'section'	=> 'italystrap_post_content_template_options',
			'type'		=> 'multicheck',
			'settings'	=> 'post_content_template',
			'choices'	=> array(
				'hide_breadcrumbs'	=> __( 'Hide breadcrumbs', 'italystrap' ),
				'hide_title'		=> __( 'Hide title', 'italystrap' ),
				'hide_meta'			=> __( 'Hide meta info', 'italystrap' ),
				'hide_thumb'		=> __( 'Hide feautured image', 'italystrap' ),
				'hide_figcaption'	=> __( 'Hide figure caption', 'italystrap' ),
				'hide_content'		=> __( 'Hide the content', 'italystrap' ),
				// 'hide_author'		=> __( 'Hide author box', 'italystrap' ),
				// 'hide_social'		=> __( 'Hide builtin social sharing', 'italystrap' ),
				// 'hide_comments'		=> __( 'Hide comments', 'italystrap' ),
				// 'hide_comments_form'=> __( 'Hide comments form', 'italystrap' ),
			),
		)
	)
);
